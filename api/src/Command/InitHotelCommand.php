<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class InitHotelCommand extends Command
{
	protected static $defaultName = 'hotel:init';
	protected static $defaultDescription = 'Initialize project (set up database, load fixtures).';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	protected function configure() : void
	{
		
	}
	
	protected function execute(InputInterface $input, OutputInterface $output) : int
	{
		$output->writeln("Initialize project.");
		
		$output->writeln("Load schema migration:");
		$command = $this->getApplication()->find('doctrine:migrations:migrate');
		$args = [''];
		$run = $command->run(new ArrayInput($args), $output);
		if($run !== Command::SUCCESS)
		{
			$output->write("Can't load database migrations.");
			return Command::FAILURE;
		}
		
		$output->writeln("Load data fixtures:");
		$command = $this->getApplication()->find('doctrine:fixtures:load');
		$args = new ArrayInput(['--n' => true]);
		$run = $command->run($args, $output);
		if($run !== Command::SUCCESS)
		{
			$output->write("Can't load database fixtures");
			return Command::FAILURE;
		}
		
		$output->writeln("Load schema migration for unit test:");
		$command = $this->getApplication()->find('doctrine:migrations:migrate');
		$args = ['--e' => 'test'];
		$run = $command->run(new ArrayInput($args), $output);
		if($run !== Command::SUCCESS)
		{
			$output->write("Can't load database imgrations for unit testing.");
			return Command::FAILURE;
		}
		
		
		
		
		return Command::SUCCESS;
	}
	
	
	
}