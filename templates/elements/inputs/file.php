<label class="form-line-label for-file" for="{name}">
                        <input class="form-line-file" type="file" id="{name}" name="data[{name}]" {params} />
                        <span>{label}</span><span class="filename"><i class="icon fa fa-upload"></i><em>{{ ($item->{name}) ? $item->{name} : 'Wczytaj plik' }}</em></span>
                    </label>