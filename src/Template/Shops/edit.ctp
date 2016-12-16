<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $shopifyShop->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $shopifyShop->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Shopify Shops'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="shopifyShops form large-9 medium-8 columns content">
    <?= $this->Form->create($shopifyShop) ?>
    <fieldset>
        <legend><?= __('Edit Shopify Shop') ?></legend>
        <?php
            echo $this->Form->input('domain');
            echo $this->Form->input('name');
            echo $this->Form->input('email');
            echo $this->Form->input('shop_owner');
            echo $this->Form->input('address1');
            echo $this->Form->input('address2');
            echo $this->Form->input('city');
            echo $this->Form->input('province_code');
            echo $this->Form->input('province');
            echo $this->Form->input('zip');
            echo $this->Form->input('country');
            echo $this->Form->input('country_code');
            echo $this->Form->input('country_name');
            echo $this->Form->input('source');
            echo $this->Form->input('phone');
            echo $this->Form->input('created_at');
            echo $this->Form->input('updated_at');
            echo $this->Form->input('customer_email');
            echo $this->Form->input('latitude');
            echo $this->Form->input('longitude');
            echo $this->Form->input('primary_location_id');
            echo $this->Form->input('primary_locale');
            echo $this->Form->input('currency');
            echo $this->Form->input('iana_timezone');
            echo $this->Form->input('money_format');
            echo $this->Form->input('money_with_currency_format');
            echo $this->Form->input('taxes_included');
            echo $this->Form->input('tax_shipping');
            echo $this->Form->input('county_taxes');
            echo $this->Form->input('plan_display_name');
            echo $this->Form->input('plan_name');
            echo $this->Form->input('has_discounts');
            echo $this->Form->input('has_gift_cards');
            echo $this->Form->input('myshopify_domain');
            echo $this->Form->input('google_apps_domain');
            echo $this->Form->input('google_apps_login_enabled');
            echo $this->Form->input('money_in_emails_format');
            echo $this->Form->input('money_with_currency_in_emails_format');
            echo $this->Form->input('eligible_for_payments');
            echo $this->Form->input('requires_extra_payments_agreement');
            echo $this->Form->input('password_enabled');
            echo $this->Form->input('has_storefront');
            echo $this->Form->input('eligible_for_card_reader_giveaway');
            echo $this->Form->input('finances');
            echo $this->Form->input('setup_required');
            echo $this->Form->input('force_ssl');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
