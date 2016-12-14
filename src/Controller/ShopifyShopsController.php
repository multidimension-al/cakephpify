<?php
namespace Multidimensional\Shopify\Controller;

use App\Controller\AppController;

/**
 * ShopifyShops Controller
 *
 * @property \App\Model\Table\ShopifyShopsTable $ShopifyShops
 */
class ShopifyShopsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['PrimaryLocations']
        ];
        $shopifyShops = $this->paginate($this->ShopifyShops);

        $this->set(compact('shopifyShops'));
        $this->set('_serialize', ['shopifyShops']);
    }

    /**
     * View method
     *
     * @param string|null $id Shopify Shop id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shopifyShop = $this->ShopifyShops->get($id, [
            'contain' => ['PrimaryLocations']
        ]);

        $this->set('shopifyShop', $shopifyShop);
        $this->set('_serialize', ['shopifyShop']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shopifyShop = $this->ShopifyShops->newEntity();
        if ($this->request->is('post')) {
            $shopifyShop = $this->ShopifyShops->patchEntity($shopifyShop, $this->request->data);
            if ($this->ShopifyShops->save($shopifyShop)) {
                $this->Flash->success(__('The shopify shop has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The shopify shop could not be saved. Please, try again.'));
            }
        }
        $primaryLocations = $this->ShopifyShops->PrimaryLocations->find('list', ['limit' => 200]);
        $this->set(compact('shopifyShop', 'primaryLocations'));
        $this->set('_serialize', ['shopifyShop']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Shopify Shop id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shopifyShop = $this->ShopifyShops->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shopifyShop = $this->ShopifyShops->patchEntity($shopifyShop, $this->request->data);
            if ($this->ShopifyShops->save($shopifyShop)) {
                $this->Flash->success(__('The shopify shop has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The shopify shop could not be saved. Please, try again.'));
            }
        }
        $primaryLocations = $this->ShopifyShops->PrimaryLocations->find('list', ['limit' => 200]);
        $this->set(compact('shopifyShop', 'primaryLocations'));
        $this->set('_serialize', ['shopifyShop']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Shopify Shop id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shopifyShop = $this->ShopifyShops->get($id);
        if ($this->ShopifyShops->delete($shopifyShop)) {
            $this->Flash->success(__('The shopify shop has been deleted.'));
        } else {
            $this->Flash->error(__('The shopify shop could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
