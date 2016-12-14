<?php
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
