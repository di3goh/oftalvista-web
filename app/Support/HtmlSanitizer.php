<?php
declare(strict_types=1);

namespace Oftalvista\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

final class HtmlSanitizer
{
    private const TAGS = ['p', 'h2', 'h3', 'ul', 'ol', 'li', 'strong', 'em', 'blockquote', 'a', 'br'];

    public static function clean(string $html): string
    {
        $document = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="utf-8" ?><div id="root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $root = $document->getElementById('root');
        if (!$root) return '';
        self::sanitizeChildren($root);
        $result = '';
        foreach ($root->childNodes as $child) $result .= $document->saveHTML($child);
        return $result;
    }

    private static function sanitizeChildren(DOMNode $parent): void
    {
        foreach (iterator_to_array($parent->childNodes) as $node) {
            if ($node instanceof DOMElement) {
                if (!in_array(strtolower($node->tagName), self::TAGS, true)) {
                    $parent->replaceChild($node->ownerDocument->createTextNode($node->textContent), $node);
                    continue;
                }
                foreach (iterator_to_array($node->attributes) as $attribute) {
                    $allowed = $node->tagName === 'a' && in_array($attribute->name, ['href', 'title'], true);
                    if (!$allowed || ($attribute->name === 'href' && !preg_match('~^(https?://|mailto:|tel:|/)~i', $attribute->value))) {
                        $node->removeAttribute($attribute->name);
                    }
                }
                if ($node->tagName === 'a') $node->setAttribute('rel', 'noopener noreferrer');
                self::sanitizeChildren($node);
            }
        }
    }
}
