<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Google\Client;
use Google\Service\Calendar;
use Carbon\Carbon;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'mulai', 'selesai', 'seharian',
        'lokasi', 'deskripsi', 'status', 'user_id', 'google_event_id'
    ];

    protected $casts = [
        'mulai' => 'datetime',
        'selesai' => 'datetime',
        'seharian' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($agenda) {
            if ($agenda->status === 'aktif') {
                $agenda->syncToGoogleCalendar();
            }
        });

        static::updated(function ($agenda) {
            if ($agenda->status === 'aktif') {
                $agenda->syncToGoogleCalendar();
            } else {
                $agenda->deleteFromGoogleCalendar();
            }
        });

        static::deleted(function ($agenda) {
            $agenda->deleteFromGoogleCalendar();
        });
    }

    private function createGoogleClient(): Client
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google-service-account.json'));
        $client->addScope(Calendar::CALENDAR);

        $httpClient = new \GuzzleHttp\Client([
            'verify' => 'C:\php-8.5.3\extras\ssl\cacert.pem',
            'timeout' => 30,
        ]);
        $client->setHttpClient($httpClient);

        return $client;
    }

    public function syncToGoogleCalendar()
    {
        try {
            $client = $this->createGoogleClient();
            $service = new Calendar($client);

            $event = new Calendar\Event([
                'summary' => $this->judul,
                'location' => $this->lokasi,
                'description' => $this->deskripsi,
            ]);

            $tz = 'Asia/Jakarta';

            if ($this->seharian) {
                $event->setStart(new Calendar\EventDateTime([
                    'date' => $this->mulai->copy()->timezone($tz)->format('Y-m-d'),
                    'timeZone' => $tz,
                ]));
                $event->setEnd(new Calendar\EventDateTime([
                    'date' => $this->mulai->copy()->timezone($tz)->addDay()->format('Y-m-d'),
                    'timeZone' => $tz,
                ]));
            } else {
                // ✅ FIX: Pakai copy()->timezone() agar tidak mutasi model
                $start = $this->mulai->copy()->timezone($tz);
                $end = $this->selesai 
                    ? $this->selesai->copy()->timezone($tz) 
                    : $this->mulai->copy()->timezone($tz)->addHours(1);

                $event->setStart(new Calendar\EventDateTime([
                    'dateTime' => $start->toRfc3339String(true),  // true = dengan offset
                    'timeZone' => $tz,
                ]));
                $event->setEnd(new Calendar\EventDateTime([
                    'dateTime' => $end->toRfc3339String(true),
                    'timeZone' => $tz,
                ]));
            }

            $calendarId = env('GOOGLE_CALENDAR_ID', 'admindesakalimanahwetan@gmail.com');

            if ($this->google_event_id) {
                $service->events->update($calendarId, $this->google_event_id, $event);
            } else {
                $created = $service->events->insert($calendarId, $event);
                $this->update(['google_event_id' => $created->id]);
            }

        } catch (\Exception $e) {
            \Log::error('Google Calendar Sync Error: ' . $e->getMessage());
        }
    }

    public function deleteFromGoogleCalendar()
    {
        if (!$this->google_event_id) return;

        try {
            $client = $this->createGoogleClient();
            $service = new Calendar($client);
            $calendarId = env('GOOGLE_CALENDAR_ID', 'admindesakalimanahwetan@gmail.com');

            $service->events->delete($calendarId, $this->google_event_id);
            $this->update(['google_event_id' => null]);

        } catch (\Exception $e) {
            \Log::error('Google Calendar Delete Error: ' . $e->getMessage());
        }
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif')->where('mulai', '>=', now()->startOfDay());
    }

    public function scopeMendatang($query)
    {
        return $query->where('mulai', '>=', now())->orderBy('mulai', 'asc');
    }
}