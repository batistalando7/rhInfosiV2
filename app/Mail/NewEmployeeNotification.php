<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Employeee;

class NewEmployeeNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;

    /**
     * Cria uma nova instância da mensagem.
     *
     * @param \App\Models\Employeee $employee
     */
    public function __construct(Employeee $employee)
    {
        $this->employee = $employee;
    }

    /**
     * o build para contruir a mensagem do e-mail.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Bem-vindo ao Gestão de Capital Humano')
                    ->view('emails.newEmployeeNotification');
    }
}
