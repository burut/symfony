<?php

# src/App/JoboardBundle/Tests/Utils/JoboardTest.php

namespace App\JoboardBundle\Tests\Utils;

use App\JoboardBundle\Utils\Joboard;

class JoboardTest extends \PHPUnit_Framework_TestCase
{
    public function testSlugify()
    {
        if (empty($text)) {
            return 'n-a';
        }
        $this->assertEquals('company', Joboard::slugify('Company'));
        $this->assertEquals('ooo-company', Joboard::slugify('ooo company'));
        $this->assertEquals('company', Joboard::slugify(' company'));
        $this->assertEquals('company', Joboard::slugify('company '));
        $this->assertEquals('n-a', Joboard::slugify(''));
        $this->assertEquals('n-a', Joboard::slugify(' - '));
        $this->assertEquals('developpeur-web', Joboard::slugify('Développeur Web'));
        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }
}