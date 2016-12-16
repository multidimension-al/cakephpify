<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Shopify Access Token'), ['action' => 'edit', $shopifyAccessToken->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Shopify Access Token'), ['action' => 'delete', $shopifyAccessToken->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopifyAccessToken->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Shopify Access Tokens'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Shopify Access Token'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="shopifyAccessTokens view large-9 medium-8 columns content">
    <h3><?= h($shopifyAccessToken->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Domain') ?></th>
            <td><?= h($shopifyAccessToken->domain) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Token') ?></th>
            <td><?= h($shopifyAccessToken->token) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($shopifyAccessToken->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($shopifyAccessToken->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($shopifyAccessToken->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Expired At') ?></th>
            <td><?= h($shopifyAccessToken->expired_at) ?></td>
        </tr>
    </table>
</div>
