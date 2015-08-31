<div class="form-input">
                        <span class="safi-checkbox">
                            <input class="form-line-checkbox" type="checkbox" id="{name}" name="data[{name}]" value="1"{{ (old('data.{name}') || $item->{name}) ? ' checked="checked"' : '' }} {params} />
                        </span>
                    </div>
                    <label class="form-line-label for-checkbox" for="{name}">{label}</label>