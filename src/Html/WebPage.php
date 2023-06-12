<?php
declare(strict_types=1);

namespace Html;

/**
 * Class Webpage : définit une page web avec une entête, un titre et un contenu.
 */
class WebPage{


    protected string $head = '';
    protected string $title;
    protected string $body = '';

    /** Constructeur de la classe WebPage. Ce constructeur créé une page web.
     * @param string $title Titre de la page web
     */
    public function __construct(string $title = '')
    {
        $this->title = $title;
    }

    /** Ajoute du contenu dans la partie body de la page web.
     * @param string $content Contenu à ajouter
     * @return void
     */
    public function appendContent(string $content)
    {
        $this->body = $this->body.$content;
    }

    /**Ajoute du contenu CSS dans l'entête de la page Web.
     * @param string $css Code CSS
     * @return void
     */
    public function appendCss(string $css)
    {
        $this->head = $this->head."<style>$css</style>";
    }

    /**Ajoute un lien vers un fichier CSS dans l'entête de la page Web.
     * @param string $url URL vers le fichier CSS
     * @return void
     */
    public function appendCssUrl(string	$url)
    {

        $this->head = $this->head."<link rel='stylesheet' href='$url'>";
    }

    /**Ajoute du contenu Javascript dans l'entête de la page Web.
     * @param string $js Code Javascript
     * @return void
     */
    public function appendJs(string $js)
    {
        $this->head = $this->head."<script>$js</script>";
    }

    /** Ajoute un lien vers un fichier Javascript dans l'entête de la page Web.
     * @param string $url URL vers le fichier Javascript
     * @return void
     */
    public function appendJsUrl(string $url)
    {
        $this->head = $this->head."<script src='$url'></script>";
    }

    /** Ajoute du contenu dans la partie head de la page web.
     * @param string $content Contenu à ajouter
     * @return void
     */
    public function appendToHead(string $content)
    {
        $this->head = $this->head.$content;
    }

    /** Retourne la chaîne de caractère contenant des caractères spéciaux.
     * @param string $string Chaîne de caractères à protéger
     * @return string
     */
    public function escapeString(string $string) : string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5);
    }

    /** Accesseur au contenu $body de la page Web.
     *
     * @return string
     */
    public function getBody() : string
    {
        return $this->body;
    }

    /** Accesseur à l'entête $head de la page Web.
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /** Acceseur à la date de la dernière modification de la page Web.
     * @return string
     */
    public function getLastModification() : string
    {
        return date("d/m/Y-H:i:s", getlastmod());
    }

    /**Accesseur au titre $title de la page Web.
     *
     * @param string $title Titre de la page Web
     * @return string
     */
    public function getTitle(string $title) : string
    {
        return $this->title;
    }

    /** Modificateur du titre $title de la page Web.
     * @param string $title $Nouveau titre
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /** Produit une page HTML complète.
     * @return string
     */
    public function toHTML() : string
    {
        $html = <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="utf-8" name="viewport">
                <title>$this->title</title>
                $this->head
            </head>
            <body>
                $this->body
            </body>
        </html>
        HTML;
        return $html;
    }
}