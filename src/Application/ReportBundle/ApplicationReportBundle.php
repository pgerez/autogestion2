<?php
namespace App\Application\ReportBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationReportBundle extends Bundle
{
	

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'ReportBundle';
    }	
	
}