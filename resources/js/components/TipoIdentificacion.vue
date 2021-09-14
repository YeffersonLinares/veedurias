<template>
    <main class="main col-12">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item" v-for="ruta in arrayRuta" :key="ruta">
                <router-link :to="{name:ruta.componente}">
                    <span v-if="ruta.nombre != ''">{{ruta.nombre}}</span>
                    <span v-else>{{ruta.componente}}</span>
                </router-link>
            </li>
        </ol>
        <div class="container-fluid">
            <!-- Tabla Listado -->
            <template v-if="listado==1">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-12 text-center">
                            <h2 class=" titulo_header">TIPOS DE IDENTIFICACION</h2>
                            <button type="button" @click="ingresarTipoIdentificacion('tipoidentificacion','create')" class="btn btn-secondary boton_nuevo" v-permiso="'add_tipo_documento'">
                                <i class="fa fa-plus-square"></i> Nuevo
                            </button>
                        </div>
                    </div>
                    <div  v-permiso="'view_tipo_documento'">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                            <option value="nombre">Nombre</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup="listarTipoIdentificacion(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarTipoIdentificacion(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <tr v-for="tipodocumento in arrayTipoidentificacion" :key="tipodocumento.id">
                                        <td>
                                            <template>
                                                <button type="button" @click="ingresarTipoIdentificacion('tipoidentificacion','update',tipodocumento)" class="btn btn-warning btn-sm">
                                                <i class="typcn typcn-edit"></i>
                                                </button> &nbsp;
                                            </template>
                                            <template>
                                                <template v-if="tipodocumento.estado" class="preview">
                                                    <button type="button" class="btn btn-danger btn-sm" @click="inactivarTipoIdentificacion(tipodocumento.id)">
                                                        <i class="typcn typcn-trash"></i>
                                                    </button>
                                                </template>
                                                <template v-else>
                                                    <button type="button" class="btn btn-info btn-sm" @click="activarTipoIdentificacion(tipodocumento.id)">
                                                        <i class="typcn typcn-tick"></i>
                                                    </button>
                                                </template>
                                            </template>
                                        </td>
                                        <td v-text="tipodocumento.nombre"></td>
                                        <td>
                                            <div v-if="tipodocumento.estado">
                                                <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-else>
                                                <span class="badge badge-danger">Inactivo</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <nav>
                                    <ul class="pagination">
                                        <li class="page-item" v-if="pagination.current_page > 1">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                        </li>
                                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                        </li>
                                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <!-- Fin Tabla Listado -->
            <!-- Formulario de Ingreso y Actualizacion-->
            <template v-if="listado==2">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <h4 class="card-title" v-text="tituloFormulario"></h4>
                        <p class="card-description">
                            Datos Basicos
                        </p>
                        <form class="forms-sample">
                            <div class="form-group">
                            <label >Nombre</label>
                                <input type="text" v-model="nombre" class="form-control" placeholder="Nombre">
                            </div>
                            <div v-show="errorFormulario" class="form-group text-center">
                                <div class="badge badge-warning col-md-10">
                                    <div v-for="error in errorMensajesFormularios" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                            <template>
                                <button v-if="tipoAccion==1" @click="createTipoIdentificacion()" type="button" class="btn btn-primary mr-2">Guardar</button>
                            </template>
                            <template>
                                <button v-if="tipoAccion==2" @click="updateTipoIdentificacion()" type="button" class="btn btn-primary mr-2">Actualizar</button>
                            </template>
                            <button class="btn btn-light" @click="cancelarIngreso()">Cancelar</button>
                        </form>
                        </div>
                    </div>
                </div>
            </template>
            <!-- Fin Formulario de Ingreso -->
        </div>
    </main>
</template>

<script>
    export default {
        props : ['ruta'],
        data (){ // Resive los Datos que llegan
            return {
                // Inicialización de Variables
                idTipoidentificacion : 0,
                nombre : '',
                arrayTipoidentificacion : [],
                listado : 1,
                tituloFormulario : '',
                tipoAccion : 0,
                errorFormulario : 0,
                errorMensajesFormularios : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : '',
                arrayRuta: [],
            }
        },
        computed:{ // Almacenamos en Chache la Paginación
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;

            }
        },
        methods : {
            cambiarPagina(page,buscar,criterio){ // Metodo encargado de realizar el cambio de pagina
                //Actualiza la página actual
                this.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                this.listarTipoIdentificacion(page,buscar,criterio);
            },
            listarTipoIdentificacion (page,buscar,criterio){ // Metodo encargado de enviar los datos al listado
                var url= this.ruta + '/tipoIdentificacion?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then( (response) => {
                    console.log(response);
                    var respuesta= response.data;
                    this.arrayTipoidentificacion = respuesta.tipoDocumentos.data;
                    this.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cancelarIngreso(){ // Metodo encargado de cancelar las acciones en los formularios
                this.listado=1;
                this.tituloFormulario = '';
                this.nombre = '';
                this.tamaño = '';
                this.errorFormulario = '';
            },
            ingresarTipoIdentificacion (modelo, accion, data = []){ // Metodo encargado de cargar los formularios de crear y actualizar
                this.listado=2;
                console.log(data['nombre']);
                switch(modelo){
                    case "tipoidentificacion":
                    {
                        switch(accion){
                            case 'create':
                            {
                                this.tituloFormulario = "Registrar Tipo de Identificacion";
                                this.nombre = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'update':
                            {
                                this.tituloFormulario = "Actualizar Tipo de Identificacion";
                                this.nombre = data['nombre'];
                                this.idTipoidentificacion = data['id'];
                                this.tipoAccion = 2;
                                break;
                            }
                        }
                    }
                }
            },
            createTipoIdentificacion(tipoAccion) { // Metodo encargado de realizar el envio de datos para la creacion
                if(this.validacionFormulario(tipoAccion)){
                    return;
                }
                var url= this.ruta + '/tipoIdentificacion/create';
                axios.post(url,{
                    'nombre' : this.nombre,
                }).then((response) => {
                    this.cancelarIngreso();
                    Swal.fire(
                        'Creado!',
                        'Se agrego el tipo de documento.',
                        'success'
                    )
                    this.listarTipoIdentificacion(1,'','nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            updateTipoIdentificacion(tipoAccion) { // Metodo encargado de realizar el envio de datos para la actualizacion
                if(this.validacionFormulario(tipoAccion)){
                    return;
                }
                var url= this.ruta + '/tipoIdentificacion/update';
                axios.put(url,{
                    'nombre' : this.nombre,
                    'id' : this.idTipoidentificacion
                }).then((response) => {
                    this.cancelarIngreso();
                     Swal.fire(
                        'Actualizado!',
                        'Modifico correctamente el tipo de documento.',
                        'success',
                        1500
                    )
                    this.listarTipoIdentificacion(1,'','nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validacionFormulario(tipoAccion) { // Metodo encargado de la validacion de los campos de los formularios
                this.errorFormulario = 0;
                this.errorMensajesFormularios = [];
                if(!this.nombre) this.errorMensajesFormularios.push("El campo Nombre es Obligatorio.");
                if(this.errorMensajesFormularios.length) this.errorFormulario = 1;

                return this.errorFormulario;
            },
            inactivarTipoIdentificacion(id) { // Metodo encargado de desactivar los registros
               Swal.fire({
                    title: 'Esta seguro de Inactivar este Tipo de Identificacion?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        var url= this.ruta + '/tipoIdentificacion/inactivar';
                        axios.put(url,{
                            'id': id
                        }).then((response) => {
                            this.listarTipoIdentificacion(1,'','nombre');
                            Swal.fire(
                                'Desactivado!',
                                'El Registro ha sido Desactivado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });

                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {

                    }
                })
            },
            activarTipoIdentificacion(id) { // Metodo encargado de activar los registros
                Swal.fire({
                    title: 'Esta seguro de Activar este Tipo de Identificacion?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        var url= this.ruta + '/tipoIdentificacion/activar';
                        axios.put(url,{
                            'id': id
                        }).then((response) => {
                            this.listarTipoIdentificacion(1,'','nombre');
                            Swal.fire(
                                'Activado!',
                                'El Registro ha sido Activado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {

                    }
                })
            }
        },
        mounted() { // Se llama el Metodo de listar para que se renderice cada vez que se cargue el componente
            this.listarTipoIdentificacion(1,this.buscar,this.criterio);
            axios.get(this.ruta +'/menus/getRutaRelativa?ruta='+this.$route.name).then((response) => { this.arrayRuta = response.data; });
        }
    }
</script>
