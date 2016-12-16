<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Shopify Access Token'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="shopifyAccessTokens index large-9 medium-8 columns content">
    <h3><?= __('Shopify Access Tokens') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('domain') ?></th>
                <th scope="col"><?= $this->Paginator->sort('token') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('expired_at') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shopifyAccessTokens as $shopifyAccessToken): ?>
            <tr>
                <td><?= $this->Number->format($shopifyAccessToken->id) ?></td>
                <td><?= h($shopifyAccessToken->domain) ?></td>
                <td><?= h($shopifyAccessToken->token) ?></td>
                <td><?= h($shopifyAccessToken->created_at) ?></td>
                <td><?= h($shopifyAccessToken->updated_at) ?></td>
                <td><?= h($shopifyAccessToken->expired_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $shopifyAccessToken->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $shopifyAccessToken->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shopifyAccessToken->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopifyAccessToken->id)]) ?>
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
