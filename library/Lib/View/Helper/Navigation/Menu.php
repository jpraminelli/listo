<?php

class Lib_View_Helper_Navigation_Menu extends Zend_View_Helper_Navigation_Menu
{

    public function menu(Zend_Navigation_Container $container = null)
    {
        $container = parent::menu($container);
        $container->setUlClass('nav');
        return $container;
    }

    protected function _renderMenu(Zend_Navigation_Container $container, $ulClass, $indent, $minDepth, $maxDepth, $onlyActive)
    {
        $html = '';

        // find deepest active
        if ($found = $this->findActive($container, $minDepth, $maxDepth)) {
            $foundPage = $found['page'];
            $foundDepth = $found['depth'];
        } else {
            $foundPage = null;
        }

        // create iterator
        $iterator = new RecursiveIteratorIterator($container,
                        RecursiveIteratorIterator::SELF_FIRST);
        if (is_int($maxDepth)) {
            $iterator->setMaxDepth($maxDepth);
        }

        // Remove o item de menu que não tenha ao menos uma opção disponível
        foreach ($iterator as $page) {
            if ($iterator->getDepth() == 0) {
                if (count($page->getPages())) {
                    $visible = false;
                    foreach ($page->getPages() as $sp) {
                        if ($this->accept($sp)) {
                            $visible = true;
                            break;
                        }
                    }
                    $page->setVisible($visible);
                }
            }

            $params = Zend_Controller_Front::getInstance()->getRequest()->getParams();

            if ($page->getResource() == "{$params['module']}:{$params['controller']}") {
                $page->setActive();
            }
        }

        // iterate container
        $prevDepth = -1;
        foreach ($iterator as $page) {
            $depth = $iterator->getDepth();
            $isActive = $page->isActive(true);
            if ($depth < $minDepth || !$this->accept($page)) {
                // page is below minDepth or not accepted by acl/visibilty
                continue;
            } else if ($onlyActive && !$isActive) {
                // page is not active itself, but might be in the active branch
                $accept = false;
                if ($foundPage) {
                    if ($foundPage->hasPage($page)) {
                        // accept if page is a direct child of the active page
                        $accept = true;
                    } else if ($foundPage->getParent()->hasPage($page)) {
                        // page is a sibling of the active page...
                        if (!$foundPage->hasPages() ||
                                is_int($maxDepth) && $foundDepth + 1 > $maxDepth) {
                            // accept if active page has no children, or the
                            // children are too deep to be rendered
                            $accept = true;
                        }
                    }
                }

                if (!$accept) {
                    continue;
                }
            }

            // make sure indentation is correct
            $depth -= $minDepth;
            $myIndent = $indent . str_repeat('        ', $depth);

            if ($depth > $prevDepth) {
                // start new ul tag
                if ($ulClass && $depth == 0) {
                    $ulClass = ' class="' . $ulClass . '"';
                } else {
                    $ulClass = ' class="dropdown-menu"';
                }
                $html .= $myIndent . '<ul' . $ulClass . '>' . self::EOL;
            } else if ($prevDepth > $depth) {
                // close li/ul tags until we're at current depth
                for ($i = $prevDepth; $i > $depth; $i--) {
                    $ind = $indent . str_repeat('        ', $i);
                    $html .= $ind . '    </li>' . self::EOL;
                    $html .= $ind . '</ul>' . self::EOL;
                }
                // close previous li tag
                $html .= $myIndent . '    </li>' . self::EOL;
            } else {
                // close previous li tag
                $html .= $myIndent . '    </li>' . self::EOL;
            }

            // render li tag and page
            if ($depth == 0) {
                $liClass = $isActive ? ' class="active dropdown"' : ' class="dropdown"';
            } else {
                $liClass = $isActive ? ' class="active"' : '';
            }

            //$liClass = $isActive ? ' class="active"' : '';
            $html .= $myIndent . '    <li' . $liClass . '>' . self::EOL
                    . $myIndent . '        ' . $this->htmlify($page) . self::EOL;

            // store as previous depth for next iteration
            $prevDepth = $depth;
        }

        if ($html) {
            // done iterating container; close open ul/li tags
            for ($i = $prevDepth + 1; $i > 0; $i--) {
                $myIndent = $indent . str_repeat('        ', $i - 1);
                $html .= $myIndent . '    </li>' . self::EOL
                        . $myIndent . '</ul>' . self::EOL;
            }
            $html = rtrim($html, self::EOL);
        }

        return $html;
    }

    public function htmlify(Zend_Navigation_Page $page)
    {
        // get label and title for translating
        $label = $page->getLabel();
        $title = $page->getTitle();

        // translate label and title?
        if ($this->getUseTranslator() && $t = $this->getTranslator()) {
            if (is_string($label) && !empty($label)) {
                $label = $t->translate($label);
            }
            if (is_string($title) && !empty($title)) {
                $title = $t->translate($title);
            }
        }

        // get attribs for element
        $attribs = array(
            'id' => $page->getId(),
            'title' => $title,
            'class' => $page->getClass()
        );

        $escape = (isset($page->escape) && (bool) $page->escape) || !(isset($page->escape));

        // does page have a href?
        if ($href = $page->getHref()) {
            $element = 'a';
            $attribs['href'] = $href;
            $attribs['target'] = $page->getTarget();
            $attribs['accesskey'] = $page->getAccessKey();
            return '<' . $element . $this->_htmlAttribs($attribs) . '>'
                    . ($escape ? $this->view->escape($label) : $label)
                    . '</' . $element . '>';
        } else {
            $element = 'a';
            $attribs['href'] = '#';
            $attribs['class'] = 'dropdown-toggle';
            $attribs['data-toggle'] = 'dropdown';

            return '<' . $element . $this->_htmlAttribs($attribs) . '>'
                    . ($escape ? $this->view->escape($label) : $label)
                    . '<b class="caret"></b>'
                    . '</' . $element . '>';
        }
    }

}
