<div class="panel panel-primary">
        
    <div class="panel-heading">        
        <h3 class="panel-title title">
            <div class="pull-right">
               
            </div>
            Tarefa nº {{$tarefa->id}}
        </h3>
    </div>

    
    {{-- Form::open(array('url' => 'tarefas/' . $tarefa->id, 'class' => '')) --}}
    <!-- <pre><?php print_r($tarefa); ?></pre> -->
        

<fieldset >
    <div class="panel-body form-horizontal ">
            @if ( !empty( $tarefa->cliente ) )    
                <div class="form-group">
                    <label for="tipo" class="col-sm-3 control-label">Cliente:</label>        
                    <div class="col-sm-9 well-sm bg-info">   
                        @include( 'clientes.panels.item', array( 'cliente' => $tarefa->cliente ) )   
                    </div>                
                </div>
            @endif

        <div class="form-group">
            <label for="tipo" class="col-sm-3 control-label">Status</label>
            <div class="col-sm-9">
                <?php if( NULL == $tarefa->done or 0 == $tarefa->done or empty($tarefa->done) ){ ?>
                        <?php if( $tarefa->atrasada() ){ ?>
                            <h2 class="title text-danger">
                                Atrasada há {{$tarefa->dias()}} dias
                            </h2>
                        <?php }else{ ?>
                            <h2 class="title text-info">
                                Aguardando <small>({{$tarefa->dias()}} dias)</small>
                            </h2>
                        <?php } ?>
                <?php } else{ ?>
                    <h2 class="title success pull-left">Concluída <small>(<span class="timeago" title="{{date('Y-m-d', strtotime($tarefa->updated_at) )}}"></span>)</small></h2>
                <?php } ?>               
                
            </div>
        </div>  
            <div class="form-group">
                <label for="tipo" class="col-sm-3 control-label">Tipo</label>
                <div class="col-sm-9">
                    {{ Form::select('tipo',
                                    array(
                                        '1' => 'Ligação', 
                                        '2' => 'Visita',
                                        '3' => 'Compromisso',
                                        '4' => 'Relatório'
                                    ),
                                    $tarefa->tipo,
                                    array( 'class'    => 'form-control',
                                           'readonly' => 'readonly',
                                           'disabled' => 'disabled' )) }}
                    <!-- <select class="form-control" name="tipo" id="tipo">
                        <option value="1">Ligação</option>
                        <option value="2">Visita</option>
                        <option value="3">Compromisso</option>
                        <option value="4">Relatório</option>
                    </select> -->
                </div>
            </div>
            <div class="form-group">
                <label for="title" class="col-sm-3 control-label">Descrição</label>     
                <div class="col-sm-9">
                    <textarea readonly class="form-control" id="title" name="title">{{$tarefa->title}}</textarea>
                </div>
            </div>        
            <div class="form-group">
                <label for="start" class="col-sm-3 control-label">Prazo</label>
                <div class="col-sm-9">
                    <input readonly type="date" class="form-control" id="start" name="start" value="{{date('Y-m-d', strtotime($tarefa->start))}}">
                </div>
            </div>


    
            <div class="form-group">
                <label for="start" class="col-sm-3 control-label">Notificações</label>
                <div class="col-sm-9">
                    
                    <div class="form-horizontal">
    
                        @if ( $tarefa->notifications )    
                            @foreach ($tarefa->notifications as $notification)
                                @include('notifications.panels.item')   
                            @endforeach                               
                        @endif                                             
                            
                    </div>
                    
                    <a class="btn btn-sm btn-success" data-toggle="modal" href='#modal-id'><i class="fa fa-plus"></i> Criar notificação</a>                      
                    
                </div>
            </div>

        </div>

    </fieldset>
    
    <div class="clearfix"></div>

        
        <div class="panel-footer clearfix">
            
            <a class="btn btn-sm btn-success" data-toggle="modal" href='#modal-id'><i class="fa fa-plus"></i> Criar notificação</a>  

            {{ Form::open(array('url' => 'tarefas/' . $tarefa->id, 'class'=>'pull-right')) }}
                <div class="btn-group">
                    <a href="{{ URL::previous() }}" class="btn btn-primary">
                        <i class="fa fa-chevron-left"></i> Voltar
                    </a>                        
                    <div class="btn-group">
                        {{ Form::button('<i class="fa fa-times"></i> Excluir', array('class' => 'btn btn-danger', 'type'=>'submit', 'onclick'=>'javascript:return confirm("Deseja excluir a tarefa da lista?")')) }}
                    </div>
                    <a href="{{ url('/tarefas/'.$tarefa->id.'/edit') }}" class="btn btn-primary">
                        <i class="fa fa-edit"></i> Editar
                    </a>                    
                    <?php if( NULL == $tarefa->done or 0 == $tarefa->done or empty($tarefa->done) ){ ?>              
                        <a class="btn btn-success" data-toggle="modal" href='#concluir_tarefa_{{$tarefa->id}}'>
                            <i class="icon-check"></i> Concluir tarefa
                        </a>
                    <?php } ?>                                              
                </div>
                {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::close() }}      
                        
        </div>                      
    
</div>


@include('notifications.panels.create', array('notification'=>$tarefa->notification))



@if ($tarefa->notification)
    <div class="modal fade" id="notification-{{$tarefa->notification->id}}">
        <div class="modal-dialog">
            
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
                
                    @include('notifications.item', $tarefa->notification)
             
        </div>
    </div>
@endif


@include('tarefas.panels.modal')