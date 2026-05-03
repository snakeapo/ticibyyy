<?php

namespace App\Console\Commands;

use App\Models\Baskets;
use App\Models\User;
use App\Services\NotificationPreferenceMailer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendAbandonedCartMail extends Command
{
    protected $signature = 'mail:abandoned-cart';
    protected $description = 'Sepette ürünü kalan müşterilere 1 gün sonra hatırlatma maili gönderir';

    public function handle(NotificationPreferenceMailer $mailer): int
    {
        $userIds = Baskets::where('updated_at', '<=', Carbon::now()->subDay())
            ->whereHas('items')
            ->pluck('user_id')
            ->filter()
            ->unique();

        $users = User::whereIn('id', $userIds)->where('notify_abandoned_cart', true)->get();
        $mailer->sendToUsers($users, 'Sepetiniz sizi bekliyor', 'Sepetinizde ürünleriniz var. Satın almayı tamamlamak için hemen ziyaret edin.', route('shopping_cart'));
        $this->info('Abandoned cart mail queued: ' . $users->count());

        return self::SUCCESS;
    }
}
