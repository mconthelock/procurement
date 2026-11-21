<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Breadcrumb Library for Mitsubishi Electric Supplier Portal (AMEC)
 * Compliant with Brand Guidelines Ver. 2.0 & DaisyUI v5 breadcrumbs component.
 */
class Breadcrumb {
    /**
     * CodeIgniter super-global instance
     * @var object
     */
    protected $ci;

    /**
     * Breadcrumb items list
     * @var array
     */
    protected $items = [];

    /**
     * Operational status badge/info on the right of breadcrumb bar
     * @var array
     */
    protected $status = [
        'show' => true,
        'text' => 'Status: Normal',
        'code' => 'Code: AMEC-TH-CHONBURI',
        'dot_class' => 'bg-success',
    ];

    /**
     * Constructor
     *
     * @param bool $autoHome Whether to automatically add the default Home item
     */
    public function __construct($autoHome = true) {
        $this->ci = get_instance();
        $this->reset($autoHome);
    }

    /**
     * Reset breadcrumb items
     *
     * @param bool $withHome Whether to include default Home link
     * @return $this
     */
    public function reset($withHome = true) {
        $this->items = [];
        if ($withHome) {
            $this->items[] = [
                'title' => 'Home',
                'url' => base_url(),
                'icon' => 'home',
                'is_active' => false,
            ];
        }
        return $this;
    }

    /**
     * Clear all breadcrumb items (alias of reset(false))
     *
     * @return $this
     */
    public function clear() {
        return $this->reset(false);
    }

    /**
     * Add a breadcrumb item
     *
     * Supports:
     * - add('Title', 'url', 'icon')
     * - add(['title' => 'Title', 'url' => 'url', 'icon' => 'icon'])
     * - add([ ['title' => 'T1', 'url' => '...'], ['title' => 'T2'] ])
     *
     * @param string|array $title
     * @param string|null $url
     * @param string|null $icon
     * @return $this
     */
    public function add($title, $url = '', $icon = '') {
        if (is_array($title)) {
            // Check if sequential array of items
            if (isset($title[0]) && is_array($title[0])) {
                foreach ($title as $item) {
                    $this->add(
                        $item['title'] ?? '',
                        $item['url'] ?? '',
                        $item['icon'] ?? ''
                    );
                }
                return $this;
            }

            // Associative array for single item
            $itemTitle = $title['title'] ?? '';
            $itemUrl = $title['url'] ?? '';
            $itemIcon = $title['icon'] ?? '';
            return $this->add($itemTitle, $itemUrl, $itemIcon);
        }

        $this->items[] = [
            'title' => (string)$title,
            'url' => (string)$url,
            'icon' => (string)$icon,
            'is_active' => false,
        ];

        return $this;
    }

    /**
     * Prepend an item to the beginning of breadcrumbs
     *
     * @param string $title
     * @param string $url
     * @param string $icon
     * @return $this
     */
    public function prepend($title, $url = '', $icon = '') {
        array_unshift($this->items, [
            'title' => (string)$title,
            'url' => (string)$url,
            'icon' => (string)$icon,
            'is_active' => false,
        ]);
        return $this;
    }

    /**
     * Replace all items
     *
     * @param array $items
     * @return $this
     */
    public function setItems(array $items) {
        $this->items = [];
        return $this->add($items);
    }

    /**
     * Get all breadcrumb items with proper is_active state
     *
     * @return array
     */
    public function getItems() {
        $count = count($this->items);
        if ($count === 0) {
            return [];
        }

        $items = $this->items;
        foreach ($items as $index => &$item) {
            $item['is_active'] = ($index === $count - 1);
        }
        unset($item);

        return $items;
    }

    /**
     * Configure operational status line
     *
     * @param string $text
     * @param string $code
     * @param string $dotClass
     * @return $this
     */
    public function setStatus($text, $code = '', $dotClass = 'bg-success') {
        $this->status['show'] = true;
        $this->status['text'] = $text;
        if ($code !== '') {
            $this->status['code'] = $code;
        }
        if ($dotClass !== '') {
            $this->status['dot_class'] = $dotClass;
        }
        return $this;
    }

    /**
     * Set raw status array
     *
     * @param array $status
     * @return $this
     */
    public function setStatusData(array $status) {
        $this->status = array_merge($this->status, $status);
        return $this;
    }

    /**
     * Hide the operational status line
     *
     * @return $this
     */
    public function hideStatus() {
        $this->status['show'] = false;
        return $this;
    }

    /**
     * Show the operational status line
     *
     * @return $this
     */
    public function showStatus() {
        $this->status['show'] = true;
        return $this;
    }

    /**
     * Get operational status settings
     *
     * @return array
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Render the breadcrumb view
     *
     * @param string $view
     * @return string
     */
    public function render($view = 'layouts/breadcrumb') {
        $data = [
            'breadcrumbs' => $this->getItems(),
            'breadcrumb_status' => $this->getStatus(),
        ];
        if (isset($this->ci->blade)) {
            return $this->ci->blade->render($view, $data);
        }
        return $this->ci->load->view($view, $data, true);
    }
}