@foreach ($contents as $content)
<?php
    $unique = uniqid(md5(microtime(true)));
?>
<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="heading-{{ $unique }}">

        <?php
            $label_color = 'default';

            switch($content['method']) {
                case 'GET':
                    $label_color = 'primary';
                break;

                case 'POST':
                    $label_color = 'success';
                break;

                case 'DELETE':
                    $label_color = 'danger';
                break;

                case 'OPTIONS':
                    $label_color = 'warning';
                break;

                default:
                    $label_color = 'default';
                break;
            }
        ?>

        <h4 class="panel-title">
            <span class="label label-{{$label_color}}">{{ $content['method'] }}</span>
            <a role="button" data-toggle="collapse" data-parent="#accordion-{{$accordion_id}}" href="#collapse-{{ $unique }}" aria-expanded="true" aria-controls="collapse-{{ $unique }}">
                {{ $content['route'] }}
            </a>
        </h4>
    </div>

    <div id="collapse-{{ $unique }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{ $unique }}">
        <div class="panel-body">

             <!-- Nav tabs -->
             <ul class="nav nav-tabs" id="php-apidoctab-{{ $unique }}">
                <li class="active"><a href="#info-{{ $unique }}" data-toggle="tab">Info</a></li>
                <li><a href="#sandbox-{{ $unique }}" data-toggle="tab">Sandbox</a></li>
             </ul>
             <!-- Tab panes -->
             <div class="tab-content">
               <div class="tab-pane active" id="info-{{ $unique }}">

                    <p style="padding-top:10px;">{{ $content['description'] }}</p>

                    <div class="table-responsive max-height-300">
                      <table class="table table-hover">
                          <thead>
                              <tr>
                                  <th>Name</th>
                                  <th>Type</th>
                                  <th>Required</th>
                                  <th>Description</th>
                              </tr>
                          </thead>
                          <tbody style="max-height:500px;">
                              @foreach($content['params'] as $param)
                                <tr>
                                  <td class="no-border">{{ $param->name }}</td>
                                  <td class="no-border">{{ $param->type }}</td>
                                  <td class="no-border">{{ $param->is_required ? 'Yes' : 'No' }}</td>
                                  <td class="no-border">{{ $param->description }}</td>
                                </tr>
                              @endforeach
                          </tbody>
                      </table>
                    </div>
               </div>
               <div class="tab-pane" id="sandbox-{{ $unique }}">
                  <div class="row">

                      <div style="margin-top:10px;" class="col-sm-12">

                        <form data-unique="{{ $unique }}" class="rest-form" role="form" method="{{ $content['method'] }}" name="form-{{ $unique }}" id="form-{{ $unique }}">

                          <input class="route" type="hidden" value="{{ $content['route'] }}"/>
                          <input class="headers" type="hidden" value="{{ json_encode($content['headers']) }}">

                          <h4>Headers</h4>
                          <div class="table-responsive max-height-300">
                            <table class="table table-condensed table-hover">
                              @foreach($content['headers'] as $param)
                                <tr>
                                  <td class="no-border"><label>{{ $param->label }}</label></td>
                                  <td class="no-border" style="padding-top:0;padding-bottom:0;">
                                    <input value="{{ $param->value }}" type="text" class="headers form-control input-md">
                                  </td>
                                </tr>
                              @endforeach
                            </table>
                          </div>

                          <hr/>

                          <div style="margin-top:10px;"></div>
                          <h4>Parameters</h4>
                          <div class="table-responsive max-height-300">
                            <table class="table table-condensed table-hover">
                              @foreach($content['request'] as $param)
                                <tr>
                                  <td class="no-border"><label>{{ $param }}</label></td>
                                  <td class="no-border" style="padding-top:0;padding-bottom:0;"><input value="" type="text" class="form-control input-md" name="{{ $param }}"></td>
                                </tr>
                              @endforeach
                            </table>
                          </div>
                          <div style="padding-top:5px;" class="pull-right clearfix">
                            <button type="submit" class="btn btn-success send" rel="{{ $unique }}"><span class="glyphicon glyphicon-send"></span> Send</button>
                          </div>
                        </form>
                      </div>
                  </div>
                  <div>
                    <h4>Response <a href="#" class="btn btn-xs btn-danger response-reset">reset</a></h4>
                    <pre id="response-{{ $unique }}"></pre>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
