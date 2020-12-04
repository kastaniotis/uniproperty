<?php

use Behat\Behat\Context\Context;
use Iconic\Uniproperty\Exception\PropertyException;
use Iconic\Uniproperty\Uniproperty;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $class;
    private $post;
    private $result;
    private $exception;

    private $existing;
    private $wrong;

    private $exception2;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->class = new class() {
            private $status;

            public function getStatus()
            {
                return $this->status;
            }

            public function setStatus($status)
            {
                $this->status = $status;
            }
        };
    }

    /**
     * @Given /^a Post with a parameter status that has a value draft$/
     */
    public function aPostWithAParameterThatHaveAValue()
    {
        $this->post = new $this->class();
        $this->post->setStatus('draft');
    }

    /**
     * @When /^I try to get the value for the parameter$/
     */
    public function iTryToGetTheValue()
    {
        $this->result = Uniproperty::get($this->post, 'status');
    }

    /**
     * @Given /^when I try to get the value of a wrong one$/
     */
    public function whenITryToGetTheValueOfAWrongOne()
    {
        try {
            $this->result = Uniproperty::get($this->post, 'wrong');
        } catch (PropertyException $exception) {
            $this->exception = get_class($exception);
        }
    }

    /**
     * @Then /^I get draft for the parameter$/
     */
    public function iGet()
    {
        assertEquals('draft', $this->result);
    }

    /**
     * @Given /^an exception for the wrong one$/
     */
    public function anExceptionForTheWrongOne()
    {
        assertEquals(PropertyException::class, $this->exception);
    }

    /**
     * @When /^I check for the existence of the property$/
     */
    public function iCheckForTheExistenceOfTheProperty()
    {
        $this->existing = Uniproperty::check($this->post, 'status');
    }

    /**
     * @Given /^I check for the existence on a wrong property$/
     */
    public function iCheckForTheExistenceOnAWrongProperty()
    {
        $this->wrong = Uniproperty::check($this->post, 'wrong');
    }

    /**
     * @Then /^I get true for the existing property$/
     */
    public function iGetTrueForTheExistingProperty()
    {
        assertTrue($this->existing);
    }

    /**
     * @Given /^I get false for the wrong property$/
     */
    public function iGetFalseForTheWrongProperty()
    {
        assertFalse($this->wrong);
    }

    /**
     * @When /^I try to change the status to published$/
     */
    public function iTryToChangeTheStatusToPublished()
    {
        Uniproperty::set($this->post, 'status', 'published');
    }

    /**
     * @Given /^when I try to change a wrong parameter to published$/
     */
    public function whenITryToChangeAWrongParameterToPublished()
    {
        try {
            Uniproperty::set($this->post, 'wrong', 'published');
        } catch (PropertyException $exception) {
            $this->exception2 = get_class($exception);
        }
    }

    /**
     * @Then /^when I get the status value it is published/
     */
    public function whenIGetTheStatusValueItIsDraft()
    {
        assertEquals('published', $this->post->getStatus());
    }

    /**
     * @Given /^I get an exception for the wrong one$/
     */
    public function iGetAnExceptionForTheWrongOne()
    {
        assertEquals($this->exception2, PropertyException::class);
    }
}
