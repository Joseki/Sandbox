<?php


namespace Blog\Latte;

use Latte\CompileException;
use Latte\Compiler;
use Latte\MacroNode;
use Latte\Macros\MacroSet;
use Latte\PhpWriter;

class ImageMacro extends MacroSet
{

    public static function install(Compiler $compiler)
    {
        /** @var ImageMacro $me */
        $me = new static($compiler);

        // n:src
        $me->addMacro(
            'src',
            null,
            null,
            function (MacroNode $node, PhpWriter $writer) use ($me) {
                return ' ?> src="<?php ' . $me->macroImage($node, $writer) . ' ?>"<?php ';
            }
        );
    }



    public function macroImage(MacroNode $node, PhpWriter $writer)
    {
        $data = explode(',', $node->args);

        if (count($data) < 2) {
            throw new CompileException('Invalid arguments count for image macro');
        }

        foreach ($data as &$value) {
            $value = trim($value);
        }

        list($image, $format) = $data;

        return $writer->write(
            "echo %escape(\$_presenter->link(':App:Image:', array('name'=>"
            . $writer->formatWord($image) . ",'format'=>" . $writer->formatWord($format) . ')))'
        );
    }
} 
