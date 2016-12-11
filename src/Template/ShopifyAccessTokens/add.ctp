<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Shopify Access Tokens'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="shopifyAccessTokens form large-9 medium-8 columns content">
    <?= $this->Form->create($shopifyAccessToken) ?>
    <fieldset>
        <legend><?= __('Add Shopify Access Token') ?></legend>
        <?php
            echo $this->Form->input('domain');
            echo $this->Form->input('token');
            echo $this->Form->input('created_at');
            echo $this->Form->input('updated_at');
            echo $this->Form->input('expired_at', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
