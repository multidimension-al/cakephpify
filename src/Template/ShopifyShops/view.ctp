<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Shopify Shop'), ['action' => 'edit', $shopifyShop->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Shopify Shop'), ['action' => 'delete', $shopifyShop->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopifyShop->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Shopify Shops'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Shopify Shop'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="shopifyShops view large-9 medium-8 columns content">
    <h3><?= h($shopifyShop->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Domain') ?></th>
            <td><?= h($shopifyShop->domain) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($shopifyShop->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($shopifyShop->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Shop Owner') ?></th>
            <td><?= h($shopifyShop->shop_owner) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address1') ?></th>
            <td><?= h($shopifyShop->address1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address2') ?></th>
            <td><?= h($shopifyShop->address2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= h($shopifyShop->city) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Province Code') ?></th>
            <td><?= h($shopifyShop->province_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Province') ?></th>
            <td><?= h($shopifyShop->province) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Zip') ?></th>
            <td><?= h($shopifyShop->zip) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Country') ?></th>
            <td><?= h($shopifyShop->country) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Country Code') ?></th>
            <td><?= h($shopifyShop->country_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Country Name') ?></th>
            <td><?= h($shopifyShop->country_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Source') ?></th>
            <td><?= h($shopifyShop->source) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phone') ?></th>
            <td><?= h($shopifyShop->phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer Email') ?></th>
            <td><?= h($shopifyShop->customer_email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Primary Locale') ?></th>
            <td><?= h($shopifyShop->primary_locale) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Currency') ?></th>
            <td><?= h($shopifyShop->currency) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Iana Timezone') ?></th>
            <td><?= h($shopifyShop->iana_timezone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Money Format') ?></th>
            <td><?= h($shopifyShop->money_format) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Money With Currency Format') ?></th>
            <td><?= h($shopifyShop->money_with_currency_format) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Plan Display Name') ?></th>
            <td><?= h($shopifyShop->plan_display_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Plan Name') ?></th>
            <td><?= h($shopifyShop->plan_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Myshopify Domain') ?></th>
            <td><?= h($shopifyShop->myshopify_domain) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Google Apps Domain') ?></th>
            <td><?= h($shopifyShop->google_apps_domain) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Google Apps Login Enabled') ?></th>
            <td><?= h($shopifyShop->google_apps_login_enabled) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Money In Emails Format') ?></th>
            <td><?= h($shopifyShop->money_in_emails_format) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Money With Currency In Emails Format') ?></th>
            <td><?= h($shopifyShop->money_with_currency_in_emails_format) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($shopifyShop->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Latitude') ?></th>
            <td><?= $this->Number->format($shopifyShop->latitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Longitude') ?></th>
            <td><?= $this->Number->format($shopifyShop->longitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Primary Location Id') ?></th>
            <td><?= $this->Number->format($shopifyShop->primary_location_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($shopifyShop->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($shopifyShop->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Taxes Included') ?></th>
            <td><?= $shopifyShop->taxes_included ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tax Shipping') ?></th>
            <td><?= $shopifyShop->tax_shipping ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('County Taxes') ?></th>
            <td><?= $shopifyShop->county_taxes ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Has Discounts') ?></th>
            <td><?= $shopifyShop->has_discounts ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Has Gift Cards') ?></th>
            <td><?= $shopifyShop->has_gift_cards ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Eligible For Payments') ?></th>
            <td><?= $shopifyShop->eligible_for_payments ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Requires Extra Payments Agreement') ?></th>
            <td><?= $shopifyShop->requires_extra_payments_agreement ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password Enabled') ?></th>
            <td><?= $shopifyShop->password_enabled ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Has Storefront') ?></th>
            <td><?= $shopifyShop->has_storefront ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Eligible For Card Reader Giveaway') ?></th>
            <td><?= $shopifyShop->eligible_for_card_reader_giveaway ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Finances') ?></th>
            <td><?= $shopifyShop->finances ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Setup Required') ?></th>
            <td><?= $shopifyShop->setup_required ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Force Ssl') ?></th>
            <td><?= $shopifyShop->force_ssl ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
