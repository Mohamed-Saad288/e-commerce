<?php

namespace App\Modules\Base\app\Filters;

use App\Modules\Base\app\Contracts\FilterContract;
use Astrotomic\Translatable\Translatable;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class BaseFilter implements FilterContract
{
    protected Request $request;

    protected string $filterName;

    protected array $rules = []; // قواعد التحقق (Validation Rules)

    protected bool $applyByDefault = false;

    public function __construct(?Request $request = null)
    {
        $this->request = $request ?? request();
        $this->filterName = class_basename($this);
    }

    /**
     * تنفيذ منطق الفلترة الفعلي داخل كل فلتر فرعي
     */
    abstract public function filter(Builder $builder): Builder;

    /**
     * نقطة دخول الـ Pipeline — يتم تمرير الفلتر عبرها
     */
    public function handle(Builder $builder, Closure $next): Builder
    {
        if ($this->shouldApply()) {
            $this->validate();
            $builder = $this->filter($builder);
        }

        return $next($builder);
    }

    /**
     * التحقق مما إذا كان الفلتر يجب أن يُطبّق
     */
    public function shouldApply(): bool
    {
        return $this->applyByDefault || $this->hasAnyParam();
    }

    /**
     * الحصول على اسم الفلتر (افتراضيًا اسم الكلاس)
     */
    public function getName(): string
    {
        return $this->filterName;
    }

    protected function validate(): void
    {
        if (! empty($this->rules)) {
            Validator::make($this->request->all(), $this->rules)->validate();
        }
    }
    /* -----------------------
     * Helpers
     * ---------------------- */

    protected function hasAnyParam(...$keys): bool
    {
        if (empty($keys)) {
            return true;
        }

        foreach ($keys as $key) {
            if ($this->request->filled($key)) {
                return true;
            }
        }

        return false;
    }

    protected function has(string $key): bool
    {
        return $this->request->filled($key);
    }

    protected function get(string $key, $default = null)
    {
        return $this->request->get($key, $default);
    }

    protected function getArray(string $key, array $default = []): array
    {
        $value = $this->get($key, $default);

        return is_array($value) ? array_filter($value) : ($value ? [$value] : $default);
    }

    protected function getInt(string $key, int $default = 0): int
    {
        return (int) $this->get($key, $default);
    }

    protected function getFloat(string $key, float $default = 0.0): float
    {
        return (float) $this->get($key, $default);
    }

    protected function getBool(string $key, bool $default = false): bool
    {
        return (bool) $this->get($key, $default);
    }

    protected function sanitize(string $value): string
    {
        return trim(strip_tags($value));
    }

    protected function isTranslatable(Model $model, string $column): bool
    {
        return in_array(Translatable::class, class_uses_recursive($model)) &&
            in_array($column, $model->translatedAttributes ?? []);
    }
}
