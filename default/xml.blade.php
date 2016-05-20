@foreach ($contents as $content)
<?php
    $unique = uniqid(md5(microtime(true)));
?>
<div class="panel panel-default">

    <div class="panel-heading" role="tab" id="heading-{{ $unique }}">

        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion-{{$accordion_id}}" href="#collapse-{{ $unique }}" aria-expanded="true" aria-controls="collapse-{{ $unique }}">
                {{ $content['name'] }}
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
                  {{ $content['description'] }}
               </div>
               <div class="tab-pane" id="sandbox-{{ $unique }}">
                  <div class="row">

                      <div style="margin-top:10px;" class="col-sm-12">

                        <form data-unique="{{ $unique }}" class="xml-form" role="form" method="post" name="form-{{ $unique }}" id="form-{{ $unique }}">

                          <input class="route" type="hidden" value="{{ $content['name'] }}"/>
                          <input class="headers" type="hidden" value="{{ json_encode($content['headers']) }}">
{{--
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
 --}}
                          <h4>Raw XML</h4>
                          <div class="form-group">
                             <textarea rows="10" class="form-control raw-xml">{{ $content['raw_xml'] }}</textarea>
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
