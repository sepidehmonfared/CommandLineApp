<?php

/**
 * InputFormat Interface
 */
interface InputFormat
{
    /**
     * FilterText
     * 
     * @param $text string
     * 
     * @return string
     */
    public function filterText(string $text): string;
}

/**
 * Contains the
 * original string ,without any filtering or formatting
 */
class Input implements InputFormat
{

    /**
     * FilterText
     *
     * @param string $text input text
     *
     * @return string
     */
    public function filterText(string $text) : string 
    {
        return $text;
    }
}

/**
 * TextFilter Class 
 * The base Decorator class doesn't contain any real filtering or formatting
 * logic
 */
class TextFilter implements InputFormat
{
    /**
     * Type of inputFormat object
     *
     * @var InputFormat
     */
    protected InputFormat $inputFormat;


    /**
     * TextFilter constructor.
     *
     * @param InputFormat $inputFormat inputFormat object
     */
    public function __construct(InputFormat $inputFormat)
    {
        $this->inputFormat = $inputFormat;
    }


    /**
     * FilterText
     *
     * @param string $text input text
     *
     * @return string
     */
    public function filterText(string $text): string
    {
        return $this->inputFormat->filterText($text);
    }
}


/**
 * This Concrete Decorator strips out all HTML tags from the given text.
 */
class PlainTextFilter extends TextFilter
{

    /**
     * FilterText
     * 
     * @param $text string
     * 
     * @return string
     */
    public function filterText(string $text): string
    {
        $text = parent::filterText($text);
        
        $text = strip_tags($text);
        $text = trim(preg_replace('/\s\s+/', ' ', $text));
        return str_replace("\n", "", $text);
    }
}


/**
 * Class XSSFilter
 */
class XSSFilter extends TextFilter
{

    /**
     * Danger tag pattern
     *
     * @var array
     */
    private array $_tagPatterns = [
        "|<script.*?>([\s\S]*)?</script>|i", // ..
    ];

    /**
     * Danger Event Pattern
     *
     * @var array
     */
    private array $_attributes = [
        "onclick", "onkeypress", "onload",//..
    ];


    /**
     * FilterText
     *
     * @param string $text input text
     *
     * @return string
     */
    public function filterText(string $text): string
    {
        $text = parent::filterText($text);

        foreach ($this->_tagPatterns as $pattern) {
            $text = preg_replace($pattern, '', $text);
        }

        foreach ($this->_attributes as $attribute) {
            $text = preg_replace_callback(
                '|<(.*?)>|', 
                function ($matches) use ($attribute) {
                    $result = preg_replace("|$attribute=|i", '', $matches[1]);
                    return "<" . $result . ">";
                },
                $text
            );
        }

        return $text;
    }
}


/**
 * Class SpecialCharsFilter
 */
class SpecialCharsFilter extends TextFilter
{
    /**
     * Special chars which should be remove
     *
     * @var array
     */
    private array $_special_chars = ['!', '@', '#', '$', '%', '^', '&', '*'];


    /**
     * FilterText
     *
     * @param string $text input text
     *
     * @return string
     */
    function filterText(string $text) :string 
    {
        $text = parent::filterText($text);
        $text = str_replace($this->_special_chars, '', $text);
        return $text;
    }
}