<?php
/**
 * CakePHPify : CakePHP Plugin for Shopify API Authentication
 * Copyright (c) Multidimension.al (http://multidimension.al)
 * Github : https://github.com/multidimension-al/cakephpify
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     (c) Multidimension.al (http://multidimension.al)
 * @link          https://github.com/multidimension-al/cakephpify CakePHPify Github
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Multidimensional\Shopify\Shell\Helper;

use Cake\Console\Helper;

class HeaderHelper extends Helper
{
    public function output($args = null)
    {
        $this->_io->out("\n\n");
        $this->_io->styles('header', ['text' => 'green']);
        $this->_io->out('<header>   _____ __  ______  ____  ____________  __</header>');
        $this->_io->out('<header>  / ___// / / / __ \/ __ \/  _/ ____/\ \/ /</header>');
        $this->_io->out('<header>  \__ \/ /_/ / / / / /_/ // // /_     \  / </header>');
        $this->_io->out('<header> ___/ / __  / /_/ / ____// // __/     / /  </header>');
        $this->_io->out('<header>/____/_/ /_/\____/_/   /___/_/       /_/   </header>');
        $this->_io->out('<header>                                           </header>');
        $this->_io->out("\n");
        $this->_io->out('<header>      CakePHP Plugin for Shopify API       </header>');
        $this->_io->out('<header>       by https://multidimension.al        </header>');
        $this->_io->out("\n\n");
    }
    
}
