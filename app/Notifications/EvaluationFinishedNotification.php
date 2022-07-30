<?php

namespace App\Notifications;

use App\Models\Category;
use App\Models\Evaluation;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvaluationFinishedNotification extends Notification
{

    private $evaluation;
    private $firstCategory;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Evaluation $evaluation)
    {
        $this->evaluation = $evaluation;
        $this->firstCategory = Category::first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        // if($this->evaluation->repository->has_observations){
        //     return (new MailMessage)
        //         ->line('¡Una evaluación ha sido reenviada!')
        //         ->subject('Nueva solicitud de revisión')
        //         ->action('Volver a revisar', route('evaluations.categories.questions.index', [$this->evaluation, 1]))
        //         ->line('¡Gracias!');
        // }

        // return (new MailMessage)
        //     ->line('¡Una nueva evaluación ha sido completada y requiere un evaluador!')
        //     ->subject('Nueva solicitud de revisión')
        //     ->action('Asignarme la evaluación', route('evaluations.assign', [$this->evaluation->id, $notifiable->id]))
        //     ->line('¡Gracias!');

        return (new MailMessage)
            ->line('¡Una evaluación ha sido enviada!')
            ->subject('Nueva solicitud de revisión')
            ->action('revisar evaluación', route('evaluations.categories.questions.index', [$this->evaluation, $this->firstCategory]))
            ->line('¡Gracias!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
