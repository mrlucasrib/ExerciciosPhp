<?php
namespace Galoa\ExerciciosPhp\TextWrap;


class Resolucao implements TextWrapInterface
{

  public function textWrap(string $text, int $length): array
  {
      if(mb_strlen($text, 'UTF-8') == 0)
          return array(null);
    $arrText = explode(" ", $text);
    $lines = array();
    $line = "";
    foreach ($arrText as $word) {
        if (mb_strlen($word, 'UTF-8') <= $length) {
            if ($length - mb_strlen($line, 'UTF-8') > mb_strlen($word, 'UTF-8') || $length - mb_strlen($line, 'UTF-8') == mb_strlen($word, 'UTF-8')+1) { // Usando > para caber o espaco
                $line = mb_strlen($line, 'UTF-8') == 0 ? $line . $word : $line . " " . $word;
            } else {
                $lines[] = $line;
//          Limpa ao mesmo tempo que adiciona a palavra
                $line = $word; // A palavra nunca será maior que a linha, por isso não é necessario verificação
            }
        } else {
            $counter = 0;
            for ($i = 0; $i < mb_strlen($word, 'UTF-8'); $i++) {
                if ($counter < $length) { // < para dar espaço ao ultimo caractere no else, se não perderia a letra
                    $line += $word[$i];
                    $counter++;
                } else {
                    $counter = 0;
                    $line += $word[$i];
                    $lines[] = $line;
                    $line = "";
                }
            }
        }
    }
    if(mb_strlen($line, 'UTF-8') != 0)
        $lines[] = $line;
    return $lines;
  }
}
//$res = new Resolucao();
//$res->textWrap("Se vi mais longe foi por estar de pé sobre ombros de gigantes", 8);