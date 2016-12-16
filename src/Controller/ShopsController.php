<?php
namespace Multidimensional\Shopify\Controller;

use App\Controller\AppController;

/**
 * Shops Controller
 *
 * @property \App\Model\Table\ShopsTable $Shops
 */
class ShopsController extends AppController
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
        $Shops = $this->paginate($this->Shops);

        $this->set(compact('Shops'));
        $this->set('_serialize', ['Shops']);
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
        $Shop = $this->Shops->get($id, [
            'contain' => ['PrimaryLocations']
        ]);

        $this->set('Shop', $Shop);
        $this->set('_serialize', ['Shop']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $Shop = $this->Shops->newEntity();
        if ($this->request->is('post')) {
            $Shop = $this->Shops->patchEntity($Shop, $this->request->data);
            if ($this->Shops->save($Shop)) {
                $this->Flash->success(__('The shopify shop has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The shopify shop could not be saved. Please, try again.'));
            }
        }
        $primaryLocations = $this->Shops->PrimaryLocations->find('list', ['limit' => 200]);
        $this->set(compact('Shop', 'primaryLocations'));
        $this->set('_serialize', ['Shop']);
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
        $Shop = $this->Shops->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $Shop = $this->Shops->patchEntity($Shop, $this->request->data);
            if ($this->Shops->save($Shop)) {
                $this->Flash->success(__('The shopify shop has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The shopify shop could not be saved. Please, try again.'));
            }
        }
        $primaryLocations = $this->Shops->PrimaryLocations->find('list', ['limit' => 200]);
        $this->set(compact('Shop', 'primaryLocations'));
        $this->set('_serialize', ['Shop']);
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
        $Shop = $this->Shops->get($id);
        if ($this->Shops->delete($Shop)) {
            $this->Flash->success(__('The shopify shop has been deleted.'));
        } else {
            $this->Flash->error(__('The shopify shop could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
