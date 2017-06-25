<?php
/**
 *      __  ___      ____  _     ___                           _                    __
 *     /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *    / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *   / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 *  /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 * CakePHPify : CakePHP Plugin for Shopify API Authentication
 * Copyright (c) Multidimension.al (http://multidimension.al)
 * Github : https://github.com/multidimension-al/cakephpify
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  Copyright © 2016-2017 Multidimension.al (http://multidimension.al)
 * @link       https://github.com/multidimension-al/cakephpify CakePHPify Github
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Multidimensional\Cakephpify\Shell\Helper;

use Cake\Console\Helper;

class HeaderHelper extends Helper
{

    /**
     * @param null $args not used
     * @return void
     */
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
