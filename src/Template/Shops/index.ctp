<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Shopify Shop'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="shopifyShops index large-9 medium-8 columns content">
    <h3><?= __('Shopify Shops') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('domain') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('shop_owner') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address1') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address2') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city') ?></th>
                <th scope="col"><?= $this->Paginator->sort('province_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('province') ?></th>
                <th scope="col"><?= $this->Paginator->sort('zip') ?></th>
                <th scope="col"><?= $this->Paginator->sort('country') ?></th>
                <th scope="col"><?= $this->Paginator->sort('country_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('country_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('source') ?></th>
                <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('latitude') ?></th>
                <th scope="col"><?= $this->Paginator->sort('longitude') ?></th>
                <th scope="col"><?= $this->Paginator->sort('primary_location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('primary_locale') ?></th>
                <th scope="col"><?= $this->Paginator->sort('currency') ?></th>
                <th scope="col"><?= $this->Paginator->sort('iana_timezone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('money_format') ?></th>
                <th scope="col"><?= $this->Paginator->sort('money_with_currency_format') ?></th>
                <th scope="col"><?= $this->Paginator->sort('taxes_included') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tax_shipping') ?></th>
                <th scope="col"><?= $this->Paginator->sort('county_taxes') ?></th>
                <th scope="col"><?= $this->Paginator->sort('plan_display_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('plan_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('has_discounts') ?></th>
                <th scope="col"><?= $this->Paginator->sort('has_gift_cards') ?></th>
                <th scope="col"><?= $this->Paginator->sort('myshopify_domain') ?></th>
                <th scope="col"><?= $this->Paginator->sort('google_apps_domain') ?></th>
                <th scope="col"><?= $this->Paginator->sort('google_apps_login_enabled') ?></th>
                <th scope="col"><?= $this->Paginator->sort('money_in_emails_format') ?></th>
                <th scope="col"><?= $this->Paginator->sort('money_with_currency_in_emails_format') ?></th>
                <th scope="col"><?= $this->Paginator->sort('eligible_for_payments') ?></th>
                <th scope="col"><?= $this->Paginator->sort('requires_extra_payments_agreement') ?></th>
                <th scope="col"><?= $this->Paginator->sort('password_enabled') ?></th>
                <th scope="col"><?= $this->Paginator->sort('has_storefront') ?></th>
                <th scope="col"><?= $this->Paginator->sort('eligible_for_card_reader_giveaway') ?></th>
                <th scope="col"><?= $this->Paginator->sort('finances') ?></th>
                <th scope="col"><?= $this->Paginator->sort('setup_required') ?></th>
                <th scope="col"><?= $this->Paginator->sort('force_ssl') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shopifyShops as $shopifyShop): ?>
            <tr>
                <td><?= $this->Number->format($shopifyShop->id) ?></td>
                <td><?= h($shopifyShop->domain) ?></td>
                <td><?= h($shopifyShop->name) ?></td>
                <td><?= h($shopifyShop->email) ?></td>
                <td><?= h($shopifyShop->shop_owner) ?></td>
                <td><?= h($shopifyShop->address1) ?></td>
                <td><?= h($shopifyShop->address2) ?></td>
                <td><?= h($shopifyShop->city) ?></td>
                <td><?= h($shopifyShop->province_code) ?></td>
                <td><?= h($shopifyShop->province) ?></td>
                <td><?= h($shopifyShop->zip) ?></td>
                <td><?= h($shopifyShop->country) ?></td>
                <td><?= h($shopifyShop->country_code) ?></td>
                <td><?= h($shopifyShop->country_name) ?></td>
                <td><?= h($shopifyShop->source) ?></td>
                <td><?= h($shopifyShop->phone) ?></td>
                <td><?= h($shopifyShop->created_at) ?></td>
                <td><?= h($shopifyShop->updated_at) ?></td>
                <td><?= h($shopifyShop->customer_email) ?></td>
                <td><?= $this->Number->format($shopifyShop->latitude) ?></td>
                <td><?= $this->Number->format($shopifyShop->longitude) ?></td>
                <td><?= $this->Number->format($shopifyShop->primary_location_id) ?></td>
                <td><?= h($shopifyShop->primary_locale) ?></td>
                <td><?= h($shopifyShop->currency) ?></td>
                <td><?= h($shopifyShop->iana_timezone) ?></td>
                <td><?= h($shopifyShop->money_format) ?></td>
                <td><?= h($shopifyShop->money_with_currency_format) ?></td>
                <td><?= h($shopifyShop->taxes_included) ?></td>
                <td><?= h($shopifyShop->tax_shipping) ?></td>
                <td><?= h($shopifyShop->county_taxes) ?></td>
                <td><?= h($shopifyShop->plan_display_name) ?></td>
                <td><?= h($shopifyShop->plan_name) ?></td>
                <td><?= h($shopifyShop->has_discounts) ?></td>
                <td><?= h($shopifyShop->has_gift_cards) ?></td>
                <td><?= h($shopifyShop->myshopify_domain) ?></td>
                <td><?= h($shopifyShop->google_apps_domain) ?></td>
                <td><?= h($shopifyShop->google_apps_login_enabled) ?></td>
                <td><?= h($shopifyShop->money_in_emails_format) ?></td>
                <td><?= h($shopifyShop->money_with_currency_in_emails_format) ?></td>
                <td><?= h($shopifyShop->eligible_for_payments) ?></td>
                <td><?= h($shopifyShop->requires_extra_payments_agreement) ?></td>
                <td><?= h($shopifyShop->password_enabled) ?></td>
                <td><?= h($shopifyShop->has_storefront) ?></td>
                <td><?= h($shopifyShop->eligible_for_card_reader_giveaway) ?></td>
                <td><?= h($shopifyShop->finances) ?></td>
                <td><?= h($shopifyShop->setup_required) ?></td>
                <td><?= h($shopifyShop->force_ssl) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $shopifyShop->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $shopifyShop->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shopifyShop->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopifyShop->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
