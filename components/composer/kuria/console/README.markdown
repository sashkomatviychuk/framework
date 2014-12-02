PHP console
===========

Base code for building console applications in PHP.

TODO

- tests
- code review


## Features

- base application and command classes
- table helper (for creating nice ascii tables)
- input/output abstraction
- ANSI color support


## Requirements

- PHP 5.3 or newer


## Advanced example

See https://github.com/ShiraNai7/cutil

Cutil is a console application built using this library.


## Example

Primitive one-file console application example.

Save it to a file and run it as `php test.php` (or what ever you called the file) from the console.

    use Kuria\Console\Application;
    use Kuria\Console\Command\Command;
    use Kuria\Console\Input\InputInterface;
    use Kuria\Console\Output\OutputInterface;
    use Kuria\Console\Output\Decorator\DecoratorInterface;

    class ExampleApplication extends Application
    {
        public function getName()
        {
            return 'Example application';
        }

        public function getUsageName()
        {
            return 'php ' .  basename(__FILE__);
        }

        protected function setup()
        {
            parent::setup();

            $this->addCommand('hello', 'HelloCommand');
        }
    }

    class HelloCommand extends Command
    {
        protected function setup()
        {
            $this
                ->setMinArguments(1)
                ->setMaxArguments(1)
                ->setArgumentNames(array('your-name'))
                ->setDescription('says hello')
            ;
        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $output
                ->write('Hello ')
                ->write($input->getArgument(0), DecoratorInterface::FG_BROWN)
            ;
        }
    }

    $app = new ExampleApplication();

    $result = $app->run($argv);

    die($result);

### Output

    $ php test.php

    Example application

    USAGE: php test.php [command-name] [arg1] ... [--param=value] [-pvalue]

    HELP: run help [command-name]  to display help for given command

     set  --no-decorate  to turn off colors
     set  --no-interact  to disable interaction
     set  --quiet|-q     to surpress output entierly
     set  --verbose|-v   to increase verbosity

    AVAILABLE COMMANDS:

     Category  Command  Description

     main      hello    says hello
               help     Displays help

    COMMAND NAME MATCHING:

    Partial command names are supported. All parts delimited by ":" or "-" can be specified only partially.
    For example: ex:fo-ba matches example:foo-bar.

    $ php test.php hello Bob
    Hello Bob
