<template>
  <div class="main col-12">
    <div class="container mt-5 mb-5">
      <label for="" class="p-2"
        >Veedurías/Listado de veedurías/Nueva veeduría</label
      >
      <div class="row p-2 text-center border shadow">
        <div class="row">
          <h1 class="text-blue"><b>NUEVA VEEDURÍA</b></h1>
        </div>
      </div>

      <form
        method="POST"
        @submit.prevent="agregarVeeduria"
        enctype="multipart/form"
        id="frmVeeduria"
      >
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="nombre" class="form-label"> <b>Nombre *</b></label>
                <input
                  type="text"
                  class="form-control"
                  id="nombre"
                  v-model="veeduria.nombre_tema"
                  name="nombre_tema"
                  maxlength="50"
                  required
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="descripcion" class="form-label"
                  ><b>Descripción *</b></label
                >
                <textarea
                  class="form-control"
                  id="descripcion"
                  style="height: 150px"
                  name="descripcion"
                  v-model="veeduria.descripcion"
                  maxlength="500"
                  required
                ></textarea>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="departamento" class="form-label"
                  ><b>Departamento *</b></label
                >
                <select
                  class="form-select"
                  id="departamento"
                  name="dep_id"
                  required
                  v-model="veeduria.dep_id"
                  @change="municipioxdepartamento()"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in departamentos"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="municipio" class="form-label"
                  ><b>Municipio *</b></label
                >

                <select
                  class="form-select"
                  id="municipio"
                  name="mun_id"
                  v-model="veeduria.mun_id"
                  required
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in departamentos"
                    :key="index"
                    :value="i.id"
                  >
                    {{ i.nombre }}
                  </option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="fecha" class="form-label"
                  ><b>Fecha de creación *</b></label
                >
                <input
                  type="date"
                  class="form-control"
                  id="fecha"
                  name="fecha_realizacion"
                  v-model="veeduria.fecha_realizacion"
                  required
                />
              </div>
            </div>
          </div>

          <!-- {{-- Columna 2 --}} -->
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="radicado" class="form-label"
                  ><b>Radicado CNE *</b></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="radicado"
                  name="radicado_CNE"
                  v-model="veeduria.radicado_CNE"
                  maxlength="50"
                  required
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="tipoArchivo" class="form-label"
                  ><b>Tipo de archivo *</b></label
                >
                <select
                  class="form-select"
                  id="tipoArchivo"
                  name="tipoArchivo"
                  v-model="veeduria.tipoArchivo"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in tipodocumentos"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>

            <div class="row mt-5">
              <div
                class="form-group files border"
                role="button"
                id="box_file"
                @click="box_file()"
              >
                <div class="row mt-5">
                  <img
                    class="img_file mx-auto d-block"
                    alt=""
                    style="width: 100px"
                    src="https://img.icons8.com/ios/452/google-docs.png"
                  />
                </div>
                <div class="row mt-1 mb-5">
                  <p class="text_file text-center">
                    Ingresa aquí tus documentos .pdf .png .jpg
                  </p>
                </div>
              </div>
            </div>
            <div class="row mb-3" v-for="(i, index) in archivos" :key="index">
              <div class="row">
                <div class="col-10">
                 {{ i.name }}
                </div>
                <div class="col-2">
                  <button
                    class="btn btn-danger btn-sm"
                    type="button"
                    @click="eliminar_archivo(index)"
                  >
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <input
          type="file"
          class="d-none"
          @change="uploadFile($event)"
          id="file"
          accept=".pdf, .png, .jpg, .xls"
        />
        <div class="row mt-2">
          <div class="col sub-title">Integrantes</div>
        </div>
        <div class="row clean_integ">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
            <div class="row">
              <div class="mb-3">
                <label for="nombreapellido" class="form-label"
                  ><b>Nombres y apellidos *</b></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="nombreapellido"
                  v-model="integrante.nombreapellido"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="tipo" class="form-label"
                  ><b>Tipo de identificación *</b></label
                >
                <select
                  class="form-select"
                  id="tipo"
                  v-model="integrante.tipo_id"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in tipoidentificacion"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="numeroiden" class="form-label"
                  ><b>Número de identificación *</b></label
                >
                <input
                  type="number"
                  class="form-control"
                  id="numeroiden"
                  maxlength="12"
                  @change="validarE"
                  v-model="integrante.numeroiden"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="direccion" class="form-label"
                  ><b>Dirección *</b></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="direccion"
                  maxlength="70"
                  v-model="integrante.direccion"
                />
              </div>
            </div>
          </div>
          <!-- {{-- Columna 2 --}} -->
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
            <div class="row">
              <div class="mb-3">
                <label for="telefono" class="form-label"
                  ><b>Teléfono *</b></label
                >
                <input
                  type="number"
                  class="form-control"
                  id="telefono"
                  maxlength="12"
                  v-model="integrante.telefono"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="email" class="form-label"
                  ><b>Correo electrónico *</b></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  maxlength="50"
                  v-model="integrante.email"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="estado" class="form-label"><b>Estado *</b></label>
                <select class="form-select" id="estado" disabled>
                  <option value="1">Activo</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <input
          type="hidden"
          v-model="veeduria.integrantes"
          name="integrantes"
          id="cantInt"
        />
        <div class="d-none" id="intCont"></div>
        <!-- <div class="d-block" id="intCont"></div> -->
        <!-- {{-- Fila 4 --}} -->
        <div class="row mt-5">
          <button
            @click="agregarIntegrante"
            class="btn-general btn"
            type="button"
            id="guardarInte"
          >
            Agregar integrante
          </button>
        </div>

        <div class="col mt-4" id="contenedorInt"></div>

        <!-- {{-- Fila 5 --}} -->
        <div class="row mt-5">
          <button class="btn-general btn" id="crearVeeduria" type="submit">
            Crear veeduría
          </button>
        </div>
      </form>
    </div>

    <!-- Inicio modal ver -->
    <div
      class="modal fade"
      id="modal_integrante"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Integrante</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row mb-2">
              <h5 class="modal-title">Integrante</h5>
              <div class="row m-3">
                <div class="col">
                  <div class="row text-style">Nombres y apellidos</div>
                  <div class="row mb-3" id="mNombre">valor nombre</div>
                  <div class="row text-style">Tipo de identificación</div>
                  <div class="row mb-3" id="mTipo">valor identificación</div>
                  <div class="row text-style">Número de identificación</div>
                  <div class="row mb-3" id="mNumeroI">123123123</div>
                  <div class="row text-style">Dirección</div>
                  <div class="row" id="mDirecc">Calle 3</div>
                </div>
                <div class="col">
                  <div class="row text-style">Teléfono</div>
                  <div class="row mb-3" id="mTel">3123123</div>
                  <div class="row text-style">Correo electrónico</div>
                  <div class="row mb-3" id="mCorreo">Correo</div>
                  <div class="row text-style">Estado</div>
                  <div class="row" id="mEstado">Activo</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin modal ver -->
  </div>
</template>

<script>
export default {
    props: ['ruta'],
  data() {
    return {
      archivos: [],
      archivo: "",
      departamentos: [],
      municipios: [],
      ciudades: [],
      tipodocumentos: [],
      tipoidentificacion: [],
      veeduria: { integrantes: 0 },
      integrante: {},
      integrantes: [],
      integrantesArray: [],
    };
  },
  created() {
    let url = this.ruta + "/nueva_veeduria_data";
    axios.post(url).then((res) => {
      this.departamentos = res.data.departamentos;
      this.ciudades = res.data.municipios;
      this.tipodocumentos = res.data.tipodocumentos;
      this.tipoidentificacion = res.data.tipoidentificacion;
    });
  },

  methods: {
    box_file() {
      $("#file").trigger("click");
    },
    uploadFile(event) {
      this.archivo = event.target.files[0];
      this.archivos.push(this.archivo);
      console.log(this.archivos);
    },
    eliminar_archivo(index) {
      this.archivos.splice(index,1)
      console.log(this.archivos);
    },
    municipioxdepartamento() {
      let id = this.veeduria.dep_id;
      let url = this.ruta +"/munxdep/" + id;
      axios.post(url).then((res) => {
        this.ciudades = res.data.ciudades;
        console.log(this.ciudades);
      });
    },
    agregarVeeduria() {
      // alert('llego')
      var formulario = new FormData()
      let nveeduria = this.veeduria;
      let url = this.ruta +"/insertar_veeduria/";
      this.integrantesArray[0] = nveeduria;
      let integr = this.integrantesArray;
      console.log(this.veeduria.integrantes);
      formulario.append('veeduria.dep_id', integr[0].dep_id)
      formulario.append('veeduria.descripcion', integr[0].descripcion)
      formulario.append('veeduria.fecha_realizacion', integr[0].fecha_realizacion)
      formulario.append('veeduria.integrantes', integr[0].integrantes)
      formulario.append('veeduria.mun_id', integr[0].mun_id)
      formulario.append('veeduria.nombre_tema', integr[0].nombre_tema)
      formulario.append('veeduria.radicado_CNE', integr[0].radicado_CNE)
      formulario.append('veeduria.tipoArchivo', integr[0].tipoArchivo)
      if(integr.length > 0){
          for (let index = 1; index < integr.length; index++) {
              formulario.append('integrantes.nombre'+index,integr[index].nombre)
              formulario.append('integrantes.correo'+index,integr[index].correo)
              formulario.append('integrantes.direccion'+index,integr[index].direccion)
              formulario.append('integrantes.estado'+index,integr[index].estado)
              formulario.append('integrantes.identificacion'+index,integr[index].identificacion)
              formulario.append('integrantes.telefono'+index,integr[index].telefono)
              formulario.append('integrantes.tipo'+index,integr[index].tipo)
      }
      for (let index = 0; index < this.archivos.length; index++) {
          formulario.append('archivo'+index, this.archivos[index])
      }
      }
      // console.log(this.integrantesArray);
      formulario.append('cantidad_archivos',this.archivos.length)
      axios.post(url, formulario).then((res) => {
        console.log(res.data);
        // alert(res.data.msg)
        Swal.fire("¡Agregado!", res.data.msg, "success");
      });
    },
    ver_detalles() {
      let datos = $(".ver_inte").data("integrante");
      $("#mEstado").text(datos.estado);
      $("#mCorreo").text(datos.correo);
      $("#mTel").text(datos.telefono);
      $("#mDirecc").text(datos.direccion);
      $("#mNumeroI").text(datos.identificacion);
      $("#mTipo").text(datos.tipo);
      $("#mNombre").text(datos.nombre);
      $("#modal_integrante").modal("show");
    },
    agregarIntegrante() {
      let nombre = $("#nombreapellido").val();
      let tipo_id = $("#tipo").val();
      let tipo = $(`#tipo option[value="${tipo_id}"]`).text();
      let identificacion = $("#numeroiden").val();
      let direccion = $("#direccion").val();
      let telefono = $("#telefono").val();
      let correo = $("#email").val();
      let estado_id = $("#estado").val();
      let estado = $(`#estado option[value="${estado_id}"]`).text();
      if (
        nombre == "" ||
        tipo_id == "" ||
        tipo_id == null ||
        identificacion == "" ||
        direccion == "" ||
        telefono == "" ||
        correo == "" ||
        estado == ""
      ) {
        Swal.fire({
          icon: "error",
          title: "Campos sin llenar",
          text: "Todos los campos para añadir un integrante son requeridos",
        });
        return;
      }

      $("#contenedorInt").append(`
                <div class="row integrante">
                    <div class="col-10 mt-2">${nombre}</div>
                    <div class="col-1">
                        <button class="btn btn-blue ver_inte" @click="ver_detalles" type="button"
                            data-integrante='{"nombre":"${nombre}", "tipo":"${tipo}", "identificacion":"${identificacion}", "direccion":"${direccion}", "telefono":"${telefono}", "correo":"${correo}", "estado":"${estado}", "tipo_id":"${tipo_id}"}'>
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="col-1">
                        <button class="btn btn-blue editar_inte" type="button" @click="prueba"
                            data-integrante='{"nombre":"${nombre}", "tipo":"${tipo}", "identificacion":"${identificacion}", "direccion":"${direccion}", "telefono":"${telefono}", "correo":"${correo}", "estado":"${estado}", "tipo_id":"${tipo_id}"}'>
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>
            `);

      $("#nombreapellido").val("");
      $("#tipo option").removeAttr("selected");
      $("#tipo").val($("#tipo option:first").val());
      $("#numeroiden").val("");
      $("#direccion").val("");
      $("#telefono").val("");
      $("#email").val("");
      $("#estado option").removeAttr("selected");
      $("#estado").val($("#estado option:first").val());

      //   var inte = 0
      this.veeduria.integrantes++;
      var integrantes = this.veeduria.integrantes;
      //   inte = integrantes
      //   this.integrantes = inte

      $("#cantInt").val(integrantes);

      $("#intCont").append(`
                <input type="text" v-model="veeduria.nombre_${integrantes}" id="nombre_${integrantes}" name="nombre_${integrantes}" value="${nombre}">
                <input type="number" v-model="veeduria.tipo_${integrantes}" id="tipo_${integrantes}" name="tipo_${integrantes}" value="${tipo_id}">
                <input type="text" v-model="veeduria.identificacion_${integrantes}" id="identificacion_${integrantes}" name="identificacion_${integrantes}" value="${identificacion}">
                <input type="text" v-model="veeduria.direccion_${integrantes}" id="direccion_${integrantes}" name="direccion_${integrantes}" value="${direccion}">
                <input type="number" v-model="veeduria.telefono_${integrantes}" id="telefono_${integrantes}" name="telefono_${integrantes}" value="${telefono}">
                <input type="text" v-model="veeduria.correo_${integrantes}" id="correo_${integrantes}" name="correo_${integrantes}" value="${correo}">
                <input type="number" v-model="veeduria.estado_${integrantes}" id="estado_${integrantes}" name="estado_${integrantes}" value="${estado_id}">
            `);

      let nombre1 = $(`#nombre_${integrantes}`).val();
      let tipo1 = $(`#tipo_${integrantes}`).val();
      let identificacion1 = $(`#identificacion_${integrantes}`).val();
      let direccion1 = $(`#direccion_${integrantes}`).val();
      let telefono1 = $(`#telefono_${integrantes}`).val();
      let correo1 = $(`#correo_${integrantes}`).val();
      let estado1 = $(`#estado_${integrantes}`).val();
      this.integrantesArray[integrantes] = {
        nombre: nombre1,
        tipo: tipo1,
        identificacion: identificacion1,
        direccion: direccion1,
        telefono: telefono1,
        correo: correo1,
        estado: estado1,
      };
      // console.log(this.integrantesArray);
    },
  },
};

$("body").on("click", ".ver_inte", function () {
  let datos = $(this).data("integrante");

  $("#mEstado").text(datos.estado);
  $("#mCorreo").text(datos.correo);
  $("#mTel").text(datos.telefono);
  $("#mDirecc").text(datos.direccion);
  $("#mNumeroI").text(datos.identificacion);
  $("#mTipo").text(datos.tipo);
  $("#mNombre").text(datos.nombre);

  $("#modal_integrante").modal("show");
});

$("body").on("click", ".editar_inte", function () {
  let nombre = $("#nombreapellido").val();
  let tipo_id = $("#tipo").val();
  let tipo = $(`#tipo option[value="${tipo_id}"]`).text();
  let identificacion = $("#numeroiden").val();
  let direccion = $("#direccion").val();
  let telefono = $("#telefono").val();
  let correo = $("#email").val();
  let estado_id = $("#estado").val();
  let estado = $(`#estado option[value="${estado_id}"]`).text();
  if (
    nombre != "" ||
    tipo_id != "" ||
    // tipo_id != null ||
    identificacion != "" ||
    direccion != "" ||
    telefono != "" ||
    correo != ""
  ) {
  } else {
    let datos = $(this).data("integrante");

    $("#nombreapellido").val(datos.nombre);
    $("#tipo option").removeAttr("selected");
    $("#tipo").val(`${datos.tipo_id}`);
    // $(`#tipo option:eq("${datos.tipo_id}")`).attr("selected", true);
    $("#numeroiden").val(datos.identificacion);
    $("#direccion").val(datos.direccion);
    $("#telefono").val(datos.telefono);
    $("#email").val(datos.correo);
    // this.integrante.tipo = datos.tipo_id;
    // console.log(this.integrante.tipo + 'esta es');
    // integrante.tipo_id = datos.tipo_id
    $("#estado option").removeAttr("selected");
    //   $("#estado").val($("#estado option:first").val());

    $(this).parent().parent().remove();
    //   alert('hay un campo para editar')
  }
});
</script>

<style>
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
