<template>
  <div>
    <div class="container mt-5 mb-5">
      <label for="" class="p-2"
        >Veedurías/Listado de veedurías/Editar veeduría</label
      >
      <div class="row p-2 text-center border shadow">
        <div class="row">
          <h1 class="text-blue"><b>EDITAR VEEDURÍA</b></h1>
        </div>
      </div>
      <form
        @submit.prevent="guardarCambios"
        enctype="multipart/form"
        id="frmEditarVeeduria"
      >
        <input type="hidden" value="" name="id_record" />
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="nombre" class="form-label"><b>Nombre </b></label>
                <input
                  type="text"
                  class="form-control"
                  id="nombre"
                  name="nombre_tema"
                  required
                  value=""
                  v-model="veedurias.nombre_tema"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="descripcion" class="form-label"
                  ><b>Descripción </b></label
                >
                <textarea
                  class="form-control"
                  id="descripcion"
                  style="height: 150px"
                  name="descripcion"
                  v-model="veedurias.descripcion"
                  v-text="veedurias.descripcion"
                  required
                ></textarea>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="departamento" class="form-label"
                  ><b>Departamento </b></label
                >
                <select
                  class="form-select"
                  id="departamento"
                  name="dep_id"
                  required
                  v-model="veedurias.dep_id"
                  @change="municipioxdepartamento()"
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
                <label for="municipio" class="form-label"
                  ><b>Municipio </b></label
                >
                <select
                  class="form-select"
                  id="municipio"
                  name="mun_id"
                  v-model="veedurias.ciu_id"
                  required
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in municipios"
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
                  ><b>Fecha de creación </b></label
                >
                <input
                  type="date"
                  class="form-control"
                  id="fecha"
                  name="fecha_realizacion"
                  required
                  value=""
                  v-model="veedurias.fecha_realizacion"
                />
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="radicado" class="form-label"
                  ><b>Radicado CNE </b></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="radicado"
                  name="radicado_CNE"
                  required
                  value=""
                  v-model="veedurias.radicado_CNE"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="tipoArchivo" class="form-label"
                  ><b>Tipo de archivo </b></label
                >
                <select
                  class="form-select"
                  id="tipoArchivo"
                  name="tipoArchivo"
                  v-model="veedurias.tipoArchivo"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in tipodocumentos"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                  <!-- @endforeach -->
                </select>
              </div>
            </div>

            <div class="row mt-5">
              <div class="form-group files border" id="box_file">
                <div class="row mt-5"></div>
                <div class="row mt-1 mb-5">
                  <p class="text_file text-center">Edita tus documentos aquí</p>
                </div>
              </div>
              <input id="file" type="file" class="form-control d-none" />
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col sub-title">Integrantes</div>
        </div>

        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
            <div class="row">
              <div class="mb-3">
                <label for="nombreapellido" class="form-label"
                  ><b>Nombres y apellidos </b></label
                >
                <input
                  type="text"
                  class="form-control"
                  v-model="integrante_edit.nombre"
                  id="nombreapellido"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="tipo" class="form-label"
                  ><b>Tipo de identificación </b></label
                >
                <select
                  class="form-select"
                  id="tipo"
                  v-model="integrante_edit.id_tipo_identificacion"
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
                  ><b>Número de identificación </b></label
                >
                <input
                  type="number"
                  class="form-control"
                  id="numeroiden"
                  maxlength="12"
                  v-model="integrante_edit.documento"
                />
                <input type="hidden" v-model="edit" />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="direccion" class="form-label"
                  ><b>Dirección </b></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="direccion"
                  v-model="integrante_edit.direccion"
                />
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
            <div class="row">
              <div class="mb-3">
                <label for="telefono" class="form-label"
                  ><b>Teléfono </b></label
                >
                <input
                  type="number"
                  class="form-control"
                  id="telefono"
                  v-model="integrante_edit.telefono"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="email" class="form-label"
                  ><b>Correo electrónico </b></label
                >
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  v-model="integrante_edit.email"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="estado" class="form-label"><b>Estado </b></label>
                <select
                  class="form-select"
                  id="estado"
                  v-model="integrante_edit.estado"
                >
                  <option value="">Selecciona</option>
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
                </select>
                <input type="hidden" v-model="index" />
              </div>
            </div>
          </div>
        </div>

        <input type="hidden" name="integrantes" id="cantInt" value="0" />
        <div class="d-none" id="intCont"></div>
        <div class="row mt-5">
          <div class="col-sm-4"></div>
          <div class="col-sm-4">
            <button
              class="btn btn-secondary active btn-block"
              type="button"
              id="guardarInte"
              @click="update_integrante"
            >
              Guardar integrante
            </button>
          </div>
        </div>

        <div class="col mt-4" id="contenedorInt">
          <div
            class="row integrante"
            v-for="(i, index) in integrantes"
            :key="index"
          >
            <div class="col-10 mt-2" v-text="i.nombre"></div>
            <div class="col-1">
              <button
                class="btn btn-blue ver_inte"
                type="button"
                @click="ver_detalles(i)"
              >
                <i class="fas fa-eye"></i>
              </button>
            </div>
            <div class="col-1">
              <button
                class="btn btn-blue editar_inte"
                type="button"
                @click="edit_integrante(i, index)"
              >
                <i class="fas fa-edit"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-sm-4"></div>
          <div class="col-sm-4">
            <button
              class="btn btn-secondary btn-block active"
              id="editarVeeduria"
              type="submit"
            >
              Guardar
            </button>
          </div>
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
              @click="cerrar_modal_detalles"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row mb-2">
              <!-- <h5 class="modal-title">Integrante</h5> -->
              <div class="row m-3">
                <div class="col">
                  <div class="row text-style">Nombres y apellidos</div>
                  <div class="row mb-3" id="mNombre">
                    <input disabled v-model="integrante.nombre" />
                  </div>
                  <div class="row text-style">Número de identificación</div>
                  <div class="row mb-3" id="mNumeroI">
                    <input disabled v-model="integrante.documento" />
                  </div>
                  <div class="row text-style">Dirección</div>
                  <div class="row" id="mDirecc">
                    <input disabled v-model="integrante.direccion" />
                  </div>
                </div>
                <div class="col">
                  <div class="row text-style">Teléfono</div>
                  <div class="row mb-3" id="mTel">
                    <input disabled v-model="integrante.telefono" />
                  </div>
                  <div class="row text-style">Correo electrónico</div>
                  <div class="row mb-3" id="mCorreo">
                    <input disabled v-model="integrante.email" />
                  </div>
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
  props: ["id_edit",'ruta'],
  data() {
    return {
      veedurias: {},
      type_document: [],
      departamentos: [],
      municipios: [],
      documents: [],
      tipodocumentos: [],
      tipoidentificacion: [],
      integrantes: [],
      integrante: {},
      integrante_edit: {},
      index: 0,
      size: 0,
      edit: 0,
    };
  },
  created() {
    let id_edit = this.id_edit;
    let url = this.ruta +"/editar_veeduria/" + id_edit;
    axios.get(url).then((res) => {
      this.veedurias = res.data.data;
      this.type_document = res.data.type_document;
      this.departamentos = res.data.departamentos;
      this.documents = res.data.documents;
      this.tipodocumentos = res.data.tipodocumentos;
      this.tipoidentificacion = res.data.tipoidentificacion;
      this.integrantes = res.data.integrantes;
      this.size = this.integrantes.length;
      let id = res.data.data.dep_id;
      let url2 = this.ruta +"/munxdep/" + id;
      axios.post(url2).then((res) => {
        this.municipios = res.data.ciudades;
      });
    });
  },
  methods: {
    ver_detalles(integrante) {
      console.log(integrante);
      this.integrante = integrante;
      $("#modal_integrante").modal("show");
    },
    cerrar_modal_detalles(){
        $('#modal_integrante').modal('hide')
    },
    municipioxdepartamento() {
      let id = this.veedurias.dep_id;
      let url = this.ruta +"/munxdep/" + id;
      axios.post(url).then((res) => {
        this.municipios = res.data.ciudades;
        //   console.log(res.data)
      });
    },
    guardar() {
      let newveeduria = this.veedurias;
      let url = this.ruta +"/editar_veeduria";
      axios.post(url, newveeduria).then((res) => {
        Swal.fire("¡Editado!", res.data.msg, "success");
      });
    },
    edit_integrante(integrante, index) {
      this.edit = 1;
      this.integrante_edit = integrante;
      this.index = index;
      console.log(this.integrante_edit.edit);
    },
    update_integrante() {
      console.log(this.integrante_edit);
      if (
        this.integrante_edit.estado != null &&
        this.integrante_edit.estado != "" &&
        this.integrante_edit.direccion != "" &&
        this.integrante_edit.documento != "" &&
        this.integrante_edit.email != "" &&
        this.integrante_edit.nombre != "" &&
        this.integrante_edit.id_tipo_identificacion != ""
      ) {
        if (this.edit == 0) {
          this.integrantes.push(this.integrante_edit);
          this.size++;
        } else {
          this.integrantes[this.index] = this.integrante_edit;
          this.edit = 0;
        }
      } else {
        Swal.fire("¡Editado!", "Todos los campos son obligatorios", "error");
      }
      this.integrante_edit = {};
      console.log(this.integrantes);
      //   Swal.fire("¡Editado!", "Integrante editado exitosamente.", "success");
    },

    guardarCambios() {
      let datos = this.integrantes;
      datos[this.size] = this.veedurias;
      let url = this.ruta +"/update_veeduria";
      axios.post(url, datos).then((res) => {
        console.log(res.data);
        this.integrantes.splice(this.size, 1);
        Swal.fire("¡Editado!", res.data.msg, "success").then((result) => {
          if (result.isConfirmed) {
            window.location.href = "lista_veeduria";
          }
        });
      });
    },
  },
};
</script>

<style scoped>
#modal_integrante input {
  background: transparent;
  border: none;
}
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
