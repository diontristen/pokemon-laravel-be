<?

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchCardsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:255',
            'types' => 'nullable|array',
            'types.*' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('tags') && is_string($this->tags)) {
            $this->merge([
                'tags' => explode(',', $this->tags),
            ]);
        }
    }
}