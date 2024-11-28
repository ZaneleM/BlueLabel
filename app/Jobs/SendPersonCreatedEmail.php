<?php

namespace App\Jobs;

use App\Mail\PersonCreatedMail;
use App\Models\Person;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPersonCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $person;

    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    public function handle()
    {
        Mail::to($this->person->email)->send(new PersonCreatedMail($this->person));
    }
}
