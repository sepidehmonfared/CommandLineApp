<?php

require_once '../src/Filter.php';


/**
 * Class FilterTest
 */
class FilterTest extends PHPUnit\Framework\TestCase
{
    const STATEMENT = "<html> <body> Hello!!
    Please visit my <a href='https://github.com/sepidehmonfared'>GithHub</a>.
    ** monfared.sepideh@gmail.com **
    <script src='https://apis.google.com/js/api.js'>
    XSSAttack();
      onload=alert('HAHA')
    </script> </body></html>";


    /**
     * Input filterText just returned the raw text without any filter
     *
     * @return void
     */
    public function testFilterText()
    {
        $input = new Input();;
        $this->assertSame('<h1>salam<h1/>', $input->filterText('<h1>salam<h1/>'));
    }

    /**
     * PlainText Filter Should remove all markdown and extra whitespace
     *
     * @return void
     */
    public function testInputWithPlainTextFilter()
    {
        $strip_filter = new PlainTextFilter(new Input());

        $result = "Hello!! Please visit my GithHub. ** monfared.sepideh@gmail.com ** XSSAttack(); onload=alert('HAHA')";
        $this->assertSame($result, $strip_filter->filterText(self::STATEMENT));
    }

    /**
     * XSS Filter Should remove all dangerous keywords like onload, onclick, ...
     *
     * @return void
     */
    public function testInputWithXSSFilter()
    {
        $filter = new XSSFilter(new Input());
        $this->assertSame(
            "<html> <body> Hello!!
    Please visit my <a href='https://github.com/sepidehmonfared'>GithHub</a>.
    ** monfared.sepideh@gmail.com **
     </body></html>",
            $filter->filterText(self::STATEMENT)
        );
    }

    /**
     * PlainText AND XSS Filters
     *
     * @return void
     */
    public function testInputWithXSSAndPlainFilter()
    {
        $filter = new PlainTextFilter(new XSSFilter(new Input()));
        $this->assertSame(
            'Hello!! Please visit my GithHub. ** monfared.sepideh@gmail.com **',
            $filter->filterText(self::STATEMENT)
        );
    }


    /**
     * SpecialCharsFilter should remove chars which defined in class
     *
     * @return void
     */
    public function testInputWithSpechialCharsAndXSSAndPlainFilter()
    {
        $filter = new SpecialCharsFilter(new PlainTextFilter(new XSSFilter(new Input)));
        $this->assertSame(
            'Hello Please visit my GithHub.  monfared.sepidehgmail.com ',
            $filter->filterText(self::STATEMENT)
        );
    }

}