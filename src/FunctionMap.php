<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core;

class FunctionMap
{
    /**
     * This array is in the same format as the function map array in PHPStan:
     *
     * '<function_name>' => ['<return_type>', '<arg_name>'=>'<arg_type>']
     *
     * For classes, or if you don't wish to define the `@phpstan-return` tag:
     *
     * '<class_name>' => [null, '<arg_name>'=>'<arg_type>']
     *
     * @link https://github.com/phpstan/phpstan-src/blob/1.10.x/resources/functionMap.php
     *
     * @var ?array<string, array<0|string, ?string>>
     */
    private $map;

    /** @var ?string $httpReturnType */
    private $httpReturnType;

    /**
     * @phpstan-assert array<string, array<0|string, ?string>> $this->map
     */
    private function initializeMap(): void
    {
        $this->map = [
            'addslashes_gpc' => ['T', '@phpstan-template' => 'T', 'gpc' => 'T'],
            'comment_class' => ['($display is true ? void : string)'],
            'current_time' => ["(\$type is 'timestamp'|'U' ? int : string)"],
            'edit_term_link' => ['($display is true ? void : string|void)'],
            'get_attachment_taxonomies' => ["(\$output is 'names' ? array<int, string> : array<string, \WP_Taxonomy>)"],
            'get_bookmark' => ["null|(\$output is 'ARRAY_A' ? array<string, mixed> : (\$output is 'ARRAY_N' ? array<int, mixed> : \stdClass))", 'output' => "'OBJECT'|'ARRAY_A'|'ARRAY_N'"],
            'get_calendar' => ['($display is true ? void : string)'],
            'get_category' => ["(\$category is object ? array<array-key, mixed>|\WP_Term : array<array-key, mixed>|\WP_Term|\WP_Error|null) & (\$output is 'ARRAY_A' ? array<string, mixed>|\WP_Error|null : (\$output is 'ARRAY_N' ? array<int, mixed>|\WP_Error|null : \WP_Term|\WP_Error|null))", 'output' => "'OBJECT'|'ARRAY_A'|'ARRAY_N'"],
            'get_category_by_path' => ["(\$output is 'ARRAY_A' ? array<string, mixed>|\WP_Error|null : (\$output is 'ARRAY_N' ? array<int, mixed>|\WP_Error|null : \WP_Term|\WP_Error|null))", 'output' => "'OBJECT'|'ARRAY_A'|'ARRAY_N'"],
            'get_comment' => ["(\$comment is \WP_Comment ? array<array-key, mixed>|\WP_Comment : array<array-key, mixed>|\WP_Comment|null) & (\$output is 'ARRAY_A' ? array<string, mixed>|null : (\$output is 'ARRAY_N' ? array<int, mixed>|null : \WP_Comment|null))", 'output' => "'OBJECT'|'ARRAY_A'|'ARRAY_N'"],
            'get_object_taxonomies' => ["(\$output is 'names' ? array<int, string> : array<string, \WP_Taxonomy>)"],
            'get_objects_in_term' => [null, 'args' => 'array{order?: string}'],
            'get_page_by_path' => ["(\$output is 'ARRAY_A' ? array<string, mixed>|null : (\$output is 'ARRAY_N' ? array<int, mixed>|null : \WP_Post|null))"],
            'get_permalink' => ['($post is \WP_Post ? string : string|false)'],
            'get_post' => ["(\$post is \WP_Post ? array<array-key, mixed>|\WP_Post : array<array-key, mixed>|\WP_Post|null) & (\$output is 'ARRAY_A' ? array<string, mixed>|null : (\$output is 'ARRAY_N' ? array<int, mixed>|null : \WP_Post|null))", 'output' => "'OBJECT'|'ARRAY_A'|'ARRAY_N'" ],
            'get_post_permalink' => ['($post is \WP_Post ? string : string|false)'],
            'get_post_stati' => ["(\$output is 'names' ? array<string, string> : array<string, \stdClass>)"],
            'get_post_types' => ["(\$output is 'names' ? array<int, string> : array<int, \WP_Post_Type>)"],
            'get_taxonomies' => ["(\$output is 'names' ? array<int, string> : array<int, \WP_Taxonomy>)"],
            'get_taxonomies_for_attachments' => ["(\$output is 'names' ? array<int, string> : array<string, \WP_Taxonomy>)"],
            'get_term' => ["(\$output is 'ARRAY_A' ? array<string, string|int>|\WP_Error|null : (\$output is 'ARRAY_N' ? list<string|int>|\WP_Error|null : \WP_Term|\WP_Error|null))", 'output' => "'OBJECT'|'ARRAY_A'|'ARRAY_N'"],
            'get_term_by' => ["(\$output is 'ARRAY_A' ? array<string, string|int>|\WP_Error|false : (\$output is 'ARRAY_N' ? list<string|int>|\WP_Error|false : \WP_Term|\WP_Error|false))"],
            'get_the_permalink' => ['($post is \WP_Post ? string : string|false)'],
            'has_action' => ['($callback is false ? bool : false|int)'],
            'has_filter' => ['($callback is false ? bool : false|int)'],
            'have_posts' => [null, '@phpstan-impure' => ''],
            'is_term' => ["(\$term is 0 ? 0 : (\$term is '' ? null : (\$taxonomy is '' ? string|null : array{term_id: string, term_taxonomy_id: string}|null)))"],
            'is_wp_error' => ['($thing is \WP_Error ? true : false)', '@phpstan-assert-if-true' => '\WP_Error $thing'],
            'mysql2date' => ["(\$format is 'G'|'U' ? int|false : string|false)"],
            'next_posts' => ['($display is true ? void : string)'],
            'post_type_archive_title' => ['($display is true ? void : string|void)'],
            'previous_posts' => ['($display is true ? void : string)'],
            'rawurlencode_deep' => ['T', '@phpstan-template' => 'T', 'value' => 'T'],
            'sanitize_category' => ['T', '@phpstan-template' => 'T of array|object', 'category' => 'T'],
            'sanitize_post' => ['T', '@phpstan-template' => 'T of array|object', 'post' => 'T'],
            'sanitize_term' => ['T', '@phpstan-template' => 'T of array|object', 'term' => 'T'],
            'single_cat_title' => ['($display is true ? void : string|void)'],
            'single_month_title' => ['($display is true ? false|void : false|string)'],
            'single_post_title' => ['($display is true ? void : string|void)'],
            'single_tag_title' => ['($display is true ? void : string|void)'],
            'single_term_title' => ['($display is true ? void : string|void)'],
            'stripslashes_deep' => ['T', '@phpstan-template' => 'T', 'value' => 'T'],
            'tag_exists' => ["(\$tag_name is 0 ? 0 : (\$tag_name is '' ? null : array{term_id: string, term_taxonomy_id: string}|null))"],
            'term_exists' => ["(\$term is 0 ? 0 : (\$term is '' ? null : (\$taxonomy is '' ? string|null : array{term_id: string, term_taxonomy_id: string}|null)))"],
            'the_date' => ['($display is true ? void : string)'],
            'the_modified_date' => ['($display is true ? void : string)'],
            'the_title' => ['($display is true ? void : string|void)'],
            'urldecode_deep' => ['T', '@phpstan-template' => 'T', 'value' => 'T'],
            'urlencode_deep' => ['T', '@phpstan-template' => 'T', 'value' => 'T'],
            'WP_Block_List' => [null, '@phpstan-implements' => 'ArrayAccess<int, WP_Block>'],
            'WP_Block_List::offsetExists' => [null, 'offset' => 'int'],
            'WP_Block_List::offsetGet' => ['WP_Block|null', 'offset' => 'int'],
            'WP_Block_List::offsetSet' => ['void', 'offset' => 'int|null'],
            'WP_Block_List::offsetUnset' => ['void', 'offset' => 'int'],
            'wp_clear_scheduled_hook' => ['(0|positive-int|($wp_error is false ? false : \WP_Error))', 'args' => self::getCronArgsType()],
            'WP_Filesystem_Base::dirlist' => [self::getFilesystemDirlistReturnType()],
            'WP_Filesystem_Direct::dirlist' => [self::getFilesystemDirlistReturnType()],
            'WP_Filesystem_FTPext::dirlist' => [self::getFilesystemDirlistReturnType()],
            'WP_Filesystem_ftpsockets::dirlist' => [self::getFilesystemDirlistReturnType()],
            'WP_Filesystem_SSH2::dirlist' => [self::getFilesystemDirlistReturnType()],
            'wp_get_schedule' => [null, 'args' => self::getCronArgsType()],
            'wp_get_scheduled_event' => [null, 'args' => self::getCronArgsType()],
            'WP_Http::get' => [$this->getHttpReturnType()],
            'WP_Http::head' => [$this->getHttpReturnType()],
            'WP_Http::post' => [$this->getHttpReturnType()],
            'WP_Http::request' => [$this->getHttpReturnType()],
            'wp_insert_attachment' => ['($wp_error is false ? 0|positive-int : positive-int|\WP_Error)'],
            'wp_insert_category' => ['($wp_error is false ? 0|positive-int : positive-int|\WP_Error)'],
            'wp_insert_link' => ['($wp_error is false ? 0|positive-int : positive-int|\WP_Error)'],
            'wp_insert_post' => ['($wp_error is false ? 0|positive-int : positive-int|\WP_Error)'],
            'WP_List_Table::display_tablenav' => ['void', 'which' => '"top"|"bottom"'],
            'WP_List_Table::pagination' => ['void', 'which' => '"top"|"bottom"'],
            'WP_List_Table::set_pagination_args' => ['void', 'args' => 'array{total_items?: int, total_pages?: int, per_page?: int}'],
            'wp_loginout' => ['($display is true ? void : string)'],
            'wp_next_scheduled' => [null, 'args' => self::getCronArgsType()],
            'WP_Query::have_posts' => [null, '@phpstan-impure' => ''],
            'wp_register' => ['($display is true ? void : string)'],
            'wp_remote_get' => [$this->getHttpReturnType()],
            'wp_remote_head' => [$this->getHttpReturnType()],
            'wp_remote_post' => [$this->getHttpReturnType()],
            'wp_remote_request' => [$this->getHttpReturnType()],
            'wp_reschedule_event' => ['($wp_error is false ? bool : true|\WP_Error)', 'args' => self::getCronArgsType()],
            'WP_REST_Request' => [null, '@phpstan-template' => 'T of array', '@phpstan-implements' => 'ArrayAccess<key-of<T>, value-of<T>>'],
            'WP_REST_Request::offsetExists' => [null, 'offset' => '@param key-of<T>'],
            'WP_REST_Request::offsetGet' => ['T[TOffset]', '@phpstan-template' => 'TOffset of key-of<T>', 'offset' => 'TOffset'],
            'WP_REST_Request::offsetSet' => ['void', '@phpstan-template' => 'TOffset of key-of<T>', 'offset' => 'TOffset', 'value' => 'T[TOffset]'],
            'WP_REST_Request::offsetUnset' => ['void', '@phpstan-template' => 'TOffset of key-of<T>', 'offset' => 'TOffset'],
            'wp_safe_remote_get' => [$this->getHttpReturnType()],
            'wp_safe_remote_head' => [$this->getHttpReturnType()],
            'wp_safe_remote_post' => [$this->getHttpReturnType()],
            'wp_safe_remote_request' => [$this->getHttpReturnType()],
            'wp_schedule_event' => ['($wp_error is false ? bool : true|\WP_Error)', 'args' => self::getCronArgsType()],
            'wp_schedule_single_event' => ['($wp_error is false ? bool : true|\WP_Error)', 'args' => self::getCronArgsType()],
            'wp_set_comment_status' => ['($wp_error is false ? bool : true|\WP_Error)'],
            'wp_slash' => ['T', '@phpstan-template' => 'T', 'value' => 'T'],
            'WP_Theme' => [null, '@phpstan-type' => "ThemeKey 'Name'|'Version'|'Status'|'Title'|'Author'|'Author Name'|'Author URI'|'Description'|'Template'|'Stylesheet'|'Template Files'|'Stylesheet Files'|'Template Dir'|'Stylesheet Dir'|'Screenshot'|'Tags'|'Theme Root'|'Theme Root URI'|'Parent Theme'"],
            'WP_Theme::get' => ["(\$header is 'Name'|'ThemeURI'|'Description'|'Author'|'AuthorURI'|'Version'|'Template'|'Status'|'Tags'|'TextDomain'|'DomainPath'|'RequiresWP'|'RequiresPHP'|'UpdateURI' ? (\$header is 'Tags' ? string[] : string) : false)"],
            'WP_Theme::offsetExists' => ['($offset is ThemeKey ? true : false)'],
            'WP_Theme::offsetGet' => ['($offset is ThemeKey ? mixed : null)'],
            'wp_title' => ['($display is true ? void : string)'],
            'wp_unschedule_event' => ['($wp_error is false ? bool : true|\WP_Error)', 'args' => self::getCronArgsType()],
            'wp_unschedule_hook' => ['($wp_error is false ? 0|positive-int|false : 0|positive-int|\WP_Error)'],
            'wp_unslash' => ['T', '@phpstan-template' => 'T', 'value' => 'T'],
            'wp_update_comment' => ['($wp_error is false ? 0|1|false : 0|1|\WP_Error)'],
            'wp_update_post' => ['($wp_error is false ? 0|positive-int : positive-int|\WP_Error)'],
            'wp_widget_rss_form' => ['void', 'args' => self::getWpWidgetRssFormArgsType(), 'inputs' => self::getWpWidgetRssFormInputsType()],
            'wpdb::get_results' => ["null|(\$output is 'ARRAY_A' ? array<string, mixed> : (\$output is 'ARRAY_N' ? array<int, mixed> : (\$output is 'OBJECT_K' ? array<string, \stdClass> : \stdClass)))", 'output' => "'OBJECT'|'OBJECT_K'|'ARRAY_A'|'ARRAY_N'"],
            'wpdb::get_row' => ["null|void|(\$output is 'ARRAY_A' ? array<string, mixed> : (\$output is 'ARRAY_N' ? array<int, mixed> : \stdClass))", 'output' => "'OBJECT'|'ARRAY_A'|'ARRAY_N'", 'y' => '0|positive-int'],
            'wpdb::prepare' => [null, 'query' => 'literal-string'],
        ];
    }

    /**
     * @phpstan-assert array<string, array<0|string, ?string>> $this->map
     * @return array<string, array<0|string, ?string>>
     */
    public function getMap(): array
    {
        if (!isset($this->map)) {
            $this->initializeMap();
        }
        return $this->map;
    }

    /**
     * @phpstan-assert array<string, array<0|string, ?string>> $this->map
     * @return array<0|string, ?string>
     */
    public function getFunction(string $name): array
    {
        if (!isset($this->map)) {
            $this->initializeMap();
        }
        return $this->map[$name] ?? [];
    }

    /**
     * @phpstan-assert array<string, array<0|string, ?string>> $this->map
     */
    public function getReturnType(string $name): ?string
    {
        $function = $this->getFunction($name);
        return $function[0] ?? null;
    }

    /**
     * @phpstan-assert array<string, array<0|string, ?string>> $this->map
     * @return array<string, ?string>
     */
    public function getParameters(string $name): array
    {
        $function = $this->getFunction($name);
        unset($function[0]);
        return $function;
    }

    /**
     * @phpstan-assert string $this->httpReturnType
     */
    private function getHttpReturnType(): string
    {
        if (!isset($this->httpReturnType)) {
            $this->initializeHttpReturnType();
        }
        return $this->httpReturnType;
    }

    /**
     * @phpstan-assert string $this->httpReturnType
     */
    private function initializeHttpReturnType(): void
    {
        $baseType = self::minify(
            'array{
                headers: %s,
                body: string,
                response: array{code: int,message: string},
                cookies: array<int, \WP_HTTP_Cookie>,
                filename: string|null,
                http_response: \WP_HTTP_Requests_Response
            }|\WP_Error'
        );

        $this->httpReturnType = sprintf(
            $baseType,
            file_exists(sprintf('%s/source/wordpress/wp-includes/Requests/Cookie/Jar.php', dirname(__DIR__)))
                ? '\Requests_Utility_CaseInsensitiveDictionary'
                : '\WpOrg\Requests\Utility\CaseInsensitiveDictionary'
        );
    }

    private static function getCronArgsType(): string
    {
        return 'list<mixed>';
    }

    private static function getWpWidgetRssFormArgsType(): string
    {
        return self::minify(
            'array{
                number: int,
                error: bool,
                title?: string,
                url?: string,
                items?: int,
                show_summary?: int,
                show_author?: int,
                show_date?: int
            }'
        );
    }

    private static function getWpWidgetRssFormInputsType(): string
    {
        return self::minify(
            'array{
                title?: string,
                url?: string,
                items?: int,
                show_summary?: int,
                show_author?: int,
                show_date?: int
            }'
        );
    }

    private static function getFilesystemDirlistReturnType(): string
    {
        $innerShape = "array{
            name: string,
            perms: string,
            permsn: string,
            owner: string|false,
            size: int|string|false,
            lastmodunix: int|string|false,
            lastmod: string|false,
            time: string|false,
            type: 'f'|'d'|'l',
            group?: string|false,
            number?: int|string|false,
            files?: array|false
        }";
        return sprintf('false|array<string, %s>', self::minify($innerShape));
    }

    private static function minify(string $string): string
    {
        return str_replace(["\r", "\n", ' '], '', $string);
    }
}
