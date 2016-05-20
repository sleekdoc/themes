<!DOCTYPE html>
<html>
    <head>
        <title>{{ $data['title'] }}</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" type="text/css" href="css/bootstrap3.3.6.min.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
    </head>
    <body>

        <div class="container">

            <div style="margin-top:20px;"></div>

            <div class="form-group">
                <label for="">Base URI</label>
                <input id="base-uri" type="text" class="form-control input-block" value="{{ $data['default_base_uri'] }}"/>
            </div>

            <hr/>

            <?php $unique_tab = uniqid(md5(microtime(true))) ?>

             <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="php-categorydoctab-{{ $unique_tab }}">
                <?php $category_active = true  ?>

                @foreach ($data['api'] as $category => $contents)
                    <li class="{{ $category_active ? 'active' : '' }}">
                        <a href="#{{ $category }}-{{ $unique_tab }}" data-toggle="tab">{{ $category }}</a>
                    </li>

                    <?php $category_active = false ?>
                @endforeach
            </ul>

            <div class="tab-content">
                <?php $category_active = true  ?>

                @foreach ($data['api'] as $category => $namespaces)

                    <div class="tab-pane {{ $category_active ? 'active' : '' }}" id="{{$category}}-{{ $unique_tab }}">

                        @foreach ($namespaces as $namespace => $contents)

                                <h4>
                                    {{ $namespace }}
                                    <div class="pull-right">
                                        <span class="namespace-info glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="{{ $contents['description'] }}"></span>
                                    </div>
                                </h4>

                                <?php $accordion_id = uniqid(md5(microtime(true))); ?>

                                <div class="panel-group" id="accordion-{{$accordion_id}}" role="tablist" aria-multiselectable="true">
                                    @include('default.'.strtolower($category), [
                                        'accordion_id' => $accordion_id,
                                        'contents'     => $contents['functions']
                                    ])
                                </div>

                            <?php $category_active = false ?>

                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>


        <script type="text/javascript" src="js/jquery1.11.3.min.js"></script>
        <script type="text/javascript" src="js/bootstrap3.3.6.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script type="text/javascript">
            $.fn.serializeObject = function()
            {
                var o = {};
                var a = this.serializeArray();
                $.each(a, function() {
                    if (o[this.name] !== undefined) {
                        if (!o[this.name].push) {
                            o[this.name] = [o[this.name]];
                        }
                        o[this.name].push(this.value || '');
                    } else {
                        o[this.name] = this.value || '';
                    }
                });
                return o;
            };

            $(function() {

                $(".namespace-info").tooltip();

                // $(".collapse").collapse();

                $('.rest-form').on('submit', function(e) {

                    e.preventDefault();

                    var form = $(this);
                    var method = form.attr('method');
                    var headers = {};

                    $.each(JSON.parse(form.find('.headers').val()), function(key, val) {
                        headers[val.label] = val.value;
                    });

                    $.ajax({
                        url: $("#base-uri").val() + form.find('.route').val(),
                        type: method,
                        data: $(this).serializeObject(),
                        headers: headers,
                        dataType: 'json',
                        success: function (data) {
                            var unique = form.data('unique');

                            $("#response-"+unique).html(JSON.stringify(data, null, 4));
                        },
                        error: function (err) {
                            $("#response-"+unique).html(JSON.stringify(data, null, 4));
                        }
                    });
                });

                $('.response-reset').on('click', function(e) {
                    e.preventDefault();

                    // console.log('triggered');

                    $(this).closest('div').find('pre').html('');
                });
            });
        </script>
    </body>
</html>