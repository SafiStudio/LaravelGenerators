<div class="form-input">
                        <input class="form-line-text" type="text" id="{name}" name="data[{name}]" value="{{ (old('data.{name}')) ? old('data.{name}') : $item->{name} }}" {params} />
                    </div>
                    <label class="form-line-label" for="{name}">{label}</label>