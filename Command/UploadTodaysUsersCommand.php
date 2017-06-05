<?php
/**
 * Created by PhpStorm.
 * User: carl
 * Date: 01/06/17
 * Time: 21:47
 */

namespace PartFire\MailChimpBundle\Command;

use PartFire\CommonBundle\Services\Output\Cli\ConsoleOutput;
use PartFire\MailChimpBundle\Model\Dto\Member;
use PartFire\MailChimpBundle\Services\Members;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class UploadTodaysUsersCommand extends ContainerAwareCommand
{
    protected $output;

    protected function configure()
    {
        $this
            ->setName('partfire:mailchimp-daily-upload')
            ->setDescription('Sends the users who registered today.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $this->getConsoleOutPutter();
        $this->output->setOutputer($output);

        $service = $this->getMailChimpService();
        $users = $this->getAllUsersWhoRegisteredToday();


        foreach ($users as $user) {
            if ($user instanceof User) {
                $dto = new Member();
                $dto->setEmail($user->getEmail());
                $dto->setFirstName($user->getFirstName());
                $dto->setLastName($user->getLastName());
                $result = $service->addUserToList($dto);
                if ($result instanceof \Exception) {
                    $this->output->comment($result->getMessage());
                }
                if ($result) {
                    $this->output->comment($user->getEmail() .' was added.');
                }
            }
        }
    }

    /**
     *@todo override this method to get your users however you do it.
     */
    protected function getAllUsersWhoRegisteredToday()
    {
        $userRepo = $this->getContainer()->get('user.repo')->getUser();
        return $userRepo->getUsersRegisteredToday();
    }

    protected function getMailChimpService() : Members
    {
        return $this->getContainer()->get('part_fire_mail_chimp.services.members');
    }

    protected function getConsoleOutPutter() : ConsoleOutput
    {
        return $this->getContainer()->get('partfire_common.output_console');
    }
}
