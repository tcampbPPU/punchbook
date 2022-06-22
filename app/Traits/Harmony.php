<?php

namespace App\Traits;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

trait Harmony
{
    public Request $request;

    public float $benchmark;

    public string $status;

    public array $query = [
        'options' => [],
        'params' => [],
    ];

    public array $errors = [];

    public array $meta = [];

    /**
     * Harmony constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->harmonyInit($request);
    }

    /**
     * Initialize Harmony
     * @param Request $request
     * @return void
     */
    public function harmonyInit(Request $request): void
    {
        $this->benchmark = microtime(true);
        $this->request = $request;
    }

    /**
     * Push option to validation stack
     * @see https://laravel.com/docs/9.x/validation#available-validation-rules
     *
     * @param string $name
     * @param array|string $rules
     * @param array $messages<string, string>
     * @return Controller
     */
    public function option(string $name, array|string $rules, array $messages = []): self
    {
        $this->query['options']['rules'][$name] = $rules;

        if (! empty($messages)) {
            $colMessages = array_map(
                fn ($message, $key) => [$name . '.' . $key => $message],
                $messages,
                array_keys($messages)
            );

            $this->query['options']['messages'] = array_merge(
                $this->query['options']['messages'] ?? [],
                ...$colMessages
            );
        }

        return $this;
    }

    /**
     * Push multiple options to validation stack
     *
     * @param array $options
     * @return Controller
     */
    public function options(array $options): self
    {
        foreach ($options as $key => $value) {
            $this->option($key, $value);
        }

        return $this;
    }

    /**
     * Return metadata stack
     *
     * @return array
     */
    public function getMeta(): array
    {
        $this->meta['benchmark'] = microtime(true) - $this->benchmark;

        return $this->meta;
    }

    /**
     * Add metadata to stack
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function addMeta(string $name, mixed $value): void
    {
        $this->meta[$name] = $value;
    }

    /**
     * Verify options through the Laravel Validator
     *
     * @param bool $abort
     * @return Response|array|bool|JsonResponse
     */
    public function verify(bool $abort = true): Response|array|bool|JsonResponse
    {
        $validate = Validator::make($this->request->all(), $this->query['options']['rules'], $this->query['options']['messages'] ?? []);

        if ($validate->fails()) {
            // Push failures to errors stack
            foreach ($validate->errors()->toArray() as $key => $value) {
                foreach ($value as $error) {
                    $this->addError($key, $error);
                }
            }

            if ($abort) {
                return $this->abort();
            }

            return false;
        }

        foreach ($this->request->all() as $key => $value) {
            if (isset($this->query['options']['rules'][$key])) {
                if ($this->isFile($value)) {
                    $value = (array) $value;
                }

                if (is_array($value)) {
                    foreach ($value as $bkey => $bvalue) {
                        if (is_resource($bvalue)) {
                            unset($value[$bkey]);
                        }
                        if ($this->isFile($bvalue)) {
                            $value[$bkey] = (array) $bvalue;
                        }
                    }
                }

                $this->query['params'][$key] = $value;
            }
        }

        return $this->query;
    }

    /**
     * Add failed item to error output stack
     *
     * @param string $message
     * @param string|array $detail
     * @param int $status
     * @param bool $source
     * @return Controller
     */
    public function addError(string $message, string|array $detail, int $status = 400, bool $source = false): self
    {
        $error = ['status' => $status, 'message' => $message];

        if ($source) {
            $error['source'] = $source;
        }

        $error['detail'] = $detail;

        $this->errors[] = $error;

        return $this;
    }

    /**
     * Render finalized output
     *
     * @param mixed $data - Data sent to output
     * @param int $code
     * @param bool $abort
     * @return Response|JsonResponse
     */
    public function render(mixed $data = false, int $code = 200, bool $abort = false): Response|JsonResponse
    {
        if (in_array($code, [Response::HTTP_BAD_REQUEST, Response::HTTP_FORBIDDEN, Response::HTTP_INTERNAL_SERVER_ERROR]) || count($this->errors) > 0) {
            $response['status'] = 'error';
            $response = array_merge($response, $data);
        } else {
            $response['status'] = 'success';
            $response = array_merge($response, $this->getMeta());
            $response['query'] = $this->normalizeQuery($this->query);
            $response['data'] = $data;
        }

        $output = response()->json($response, $code, [], JSON_PRETTY_PRINT);

        if ($abort) {
            return abort($output);
        }

        return $output;
    }

    /**
     * Render finalized success output
     *
     * @param string $message
     * @param array $replace
     * @param mixed $data
     * @return Response|JsonResponse
     */
    public function success(string $message = 'Successful', array $replace = [], mixed $data = []): Response|JsonResponse
    {
        return $this->render([
            'success' => true,
            'type' => 'success',
            'message' => __($message, $replace),
            'data' => $data,
        ], Response::HTTP_OK);
    }

    /**
     * Render finalized warning output
     *
     * @param string $message
     * @param array $replace
     * @param mixed $data
     * @return Response|JsonResponse
     */
    public function warn(string $message = 'Warning', array $replace = [], mixed $data = []): Response|JsonResponse
    {
        return $this->render([
            'success' => false,
            'type' => 'warning',
            'message' => __($message, $replace),
            'data' => $data,
        ], Response::HTTP_OK);
    }

    /**
     * Render finalized error output
     *
     * @param string $key
     * @param string|array|null $replace
     * @param int $status
     * @param bool $source
     * @return Response|JsonResponse
     */
    public function error(string $key, string|array|null $replace = null, int $status = Response::HTTP_BAD_REQUEST, bool $source = false): Response|JsonResponse
    {
        $translation = __($key, is_array($replace) ? $replace : []) ?? '';

        $this->addError($key, $translation, $status, $source);

        return $this->render([
            'errors' => $this->errors,
        ], $status);
    }

    /**
     * Render errors and abort
     *
     * @return Response|JsonResponse
     */
    public function abort(): Response | JsonResponse
    {
        return $this->render([
            'errors' => $this->errors,
        ], Response::HTTP_BAD_REQUEST, true);
    }

    /**
     * Detect if a validation item is an object and of type File
     *
     * @param mixed $value
     * @return bool
     */
    private function isFile(mixed $value): bool
    {
        return is_object($value) && in_array(
            get_class($value),
            ['Illuminate\Http\UploadedFile', 'Illuminate\Http\Testing\File']
        );
    }

    /**
     * Normalize query metadata
     *
     * @param array $query
     * @return array
     */
    private function normalizeQuery(array $query): array
    {
        $output = [];
        $params = $query['params'] ?? [];
        $options = [];
        $rules = $query['options']['rules'] ?? [];

        foreach ($rules as $key => $value) {
            $options[$key] = is_array($value) ? $value : explode('|', $value);
        }

        $output['options'] = $options;
        $output['params'] = $params;

        return $output;
    }

    /**
     * Add pagination metadata to the meta stack
     *
     * @param mixed $collection
     * @param int $perPage
     * @return array
     */
    public function paginate(mixed $collection, int $perPage = 50): array
    {
        if (is_string($collection)) {
            $collection = $collection::paginate($perPage);
        } else {
            $collection = $collection->paginate($perPage);
        }

        $paginator = new LengthAwarePaginator(
            items: $collection->items(),
            total: $collection->total(),
            perPage: $perPage,
            currentPage: $collection->currentPage(),
            options: ['path' => $this->request->url()]
        );

        $pages = [];

        $paginator->onEachSide(2);

        // @see https://github.com/jasongrimes/php-paginator/blob/master/src/JasonGrimes/Paginator.php#L197
        $paginator->linkCollection()
            ->each(function ($page) use (&$pages) {
                array_push($pages, is_numeric($page['label']) ? (int) $page['label'] : $page['label']);
            });

        $this->addMeta('paginate', [
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'current_page' => $collection->currentPage(),
            'last_page' => $collection->lastPage(),
            'first_item' => $collection->firstItem(),
            'last_item' => $collection->lastItem(),
            'pages' => $pages,
        ]);

        return $collection->items();
    }
}
