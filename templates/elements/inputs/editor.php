<div class="form-input">
                        <textarea class="form-line-textarea" id="{name}" name="data[{name}]" {params}>{{ (old('data.{name}')) ? old('data.{name}') : $item->{name} }}</textarea>
                    </div>
                    <label class="form-line-label" for="{name}">{label}</label>
                    <script>
                        CKEDITOR.replace('{name}');
                    </script>
