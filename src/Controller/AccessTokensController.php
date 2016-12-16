<?php
namespace Multidimensional\Shopify\Controller;

use App\Controller\AppController;

/**
 * AccessTokens Controller
 *
 * @property \Shopify\Model\Table\AccessTokensTable $AccessTokens
 */
class AccessTokensController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $AccessTokens = $this->paginate($this->AccessTokens);

        $this->set(compact('AccessTokens'));
        $this->set('_serialize', ['AccessTokens']);
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
        $AccessToken = $this->AccessTokens->get($id, [
            'contain' => []
        ]);

        $this->set('AccessToken', $AccessToken);
        $this->set('_serialize', ['AccessToken']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $AccessToken = $this->AccessTokens->newEntity();
        if ($this->request->is('post')) {
            $AccessToken = $this->AccessTokens->patchEntity($AccessToken, $this->request->data);
            if ($this->AccessTokens->save($AccessToken)) {
                $this->Flash->success(__('The shopify access token has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The shopify access token could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('AccessToken'));
        $this->set('_serialize', ['AccessToken']);
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
        $AccessToken = $this->AccessTokens->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $AccessToken = $this->AccessTokens->patchEntity($AccessToken, $this->request->data);
            if ($this->AccessTokens->save($AccessToken)) {
                $this->Flash->success(__('The shopify access token has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The shopify access token could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('AccessToken'));
        $this->set('_serialize', ['AccessToken']);
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
        $AccessToken = $this->AccessTokens->get($id);
        if ($this->AccessTokens->delete($AccessToken)) {
            $this->Flash->success(__('The shopify access token has been deleted.'));
        } else {
            $this->Flash->error(__('The shopify access token could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
