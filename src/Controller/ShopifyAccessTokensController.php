<?php
namespace Shopify\Controller;

use Shopify\Controller\AppController;

/**
 * ShopifyAccessTokens Controller
 *
 * @property \Shopify\Model\Table\ShopifyAccessTokensTable $ShopifyAccessTokens
 */
class ShopifyAccessTokensController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $shopifyAccessTokens = $this->paginate($this->ShopifyAccessTokens);

        $this->set(compact('shopifyAccessTokens'));
        $this->set('_serialize', ['shopifyAccessTokens']);
    }

    /**
     * View method
     *
     * @param string|null $id Shopify Access Token id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shopifyAccessToken = $this->ShopifyAccessTokens->get($id, [
            'contain' => []
        ]);

        $this->set('shopifyAccessToken', $shopifyAccessToken);
        $this->set('_serialize', ['shopifyAccessToken']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shopifyAccessToken = $this->ShopifyAccessTokens->newEntity();
        if ($this->request->is('post')) {
            $shopifyAccessToken = $this->ShopifyAccessTokens->patchEntity($shopifyAccessToken, $this->request->data);
            if ($this->ShopifyAccessTokens->save($shopifyAccessToken)) {
                $this->Flash->success(__('The shopify access token has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The shopify access token could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('shopifyAccessToken'));
        $this->set('_serialize', ['shopifyAccessToken']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Shopify Access Token id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shopifyAccessToken = $this->ShopifyAccessTokens->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shopifyAccessToken = $this->ShopifyAccessTokens->patchEntity($shopifyAccessToken, $this->request->data);
            if ($this->ShopifyAccessTokens->save($shopifyAccessToken)) {
                $this->Flash->success(__('The shopify access token has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The shopify access token could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('shopifyAccessToken'));
        $this->set('_serialize', ['shopifyAccessToken']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Shopify Access Token id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shopifyAccessToken = $this->ShopifyAccessTokens->get($id);
        if ($this->ShopifyAccessTokens->delete($shopifyAccessToken)) {
            $this->Flash->success(__('The shopify access token has been deleted.'));
        } else {
            $this->Flash->error(__('The shopify access token could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
