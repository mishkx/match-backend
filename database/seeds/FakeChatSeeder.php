<?php

use App\Models\Account\User;
use App\Traits\FakerTrait;
use Illuminate\Database\Seeder;
use App\Models\Chat\Thread;
use App\Models\Chat\Participant;
use App\Models\Chat\Message;

class FakeChatSeeder extends Seeder
{
    use FakerTrait;

    private const USER_MAX_RECIPIENTS = 10;
    private const MAX_MASSAGES = 5;

    public function run()
    {
        $this->createParticipants();
        $this->createMessages();
    }

    private function createParticipants()
    {
        $continue = true;

        while ($continue) {

            $user = User::query()
                ->whereDoesntHave('participants')
                ->inRandomOrder()
                ->first();

            if (!$user) {
                $continue = false;
                return;
            }

            $recipients = User::where('id', '!=', $user->id)
                ->limit($this->faker()->numberBetween(1, self::USER_MAX_RECIPIENTS))
                ->inRandomOrder()
                ->get();

            if (!$recipients) {
                $continue = false;
                return;
            }

            $recipients->each(function (User $recipient) use ($user) {
                $thread = factory(Thread::class)->create();
                /** @var Thread $thread */
                $thread->users()->sync([
                    $user->id,
                    $recipient->id,
                ]);
            });
        }

    }

    private function createMessages()
    {
        Participant::each(function (Participant $participant) {
            factory(Message::class, $this->faker()->numberBetween(1, self::MAX_MASSAGES))->create([
                'participant_id' => $participant->id,
            ]);
            $visitedAt = $participant->messages->max('created_at');
            if (!$participant->created_at) {
                $participant->update([
                    'created_at' => now(),
                ]);
            }
            $participant->update([
                'visited_at' => $visitedAt,
            ]);
            $participant->thread->update([
                'refreshed_at' => $participant->thread->refreshed_at && $participant->thread->refreshed_at->gt($visitedAt)
                    ? $participant->thread->refreshed_at
                    : $visitedAt,
            ]);
        });

    }
}
