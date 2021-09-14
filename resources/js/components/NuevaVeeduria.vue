<template>
  <div class="main col-12">
    <div class="container mt-5 mb-5">
      <label for="" class="p-2"
        >Veedurías/Listado de veedurías/Nueva veeduría</label
      >
      <div class="row p-2 text-center border shadow">
        <div class="row">
        <div class="col-md-9">
          <h1 class="text-blue"><b>NUEVA VEEDURÍA</b></h1>
        </div>
        <div class="col-md-3 mt-2">
            <button class="btn btn-warning btn-block text-white" @click="regresar">Regresar</button>
        </div>
        </div>
      </div>

      <form method="POST" enctype="multipart/form" id="frmVeeduria">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="nombre" class="form-label"> <b>Nombre *</b></label>
                <input
                  type="text"
                  class="form-control"
                  maxlength="50"
                  v-model="veeduria.nombre"
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
                  style="height: 150px"
                  maxlength="500"
                  v-model="veeduria.descripcion"
                ></textarea>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="radicado" class="form-label"
                  ><b>Tipo de veeduría *</b></label
                >
                <select class="form-select" v-model="veeduria.tipo_veeduria">
                  <option value="">Seleccione</option>
                  <option
                    v-for="(i, index) in tipo_veeduria"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>
            <div class="row" v-if="veeduria.tipo_veeduria == '2' || veeduria.tipo_veeduria == '3' || veeduria.tipo_veeduria == '4'">
              <div class="mb-3">
                <label for="departamento" class="form-label"
                  ><b>Departamento *</b></label
                >
                <select
                  v-model="veeduria.departamento"
                  class="form-select"
                  id="departamento"
                  required
                  @change="ciudadesxdep(veeduria.departamento)"
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
            <div class="row" v-if="veeduria.tipo_veeduria == '3' || veeduria.tipo_veeduria == '4'">
              <div class="mb-3">
                <label for="municipio" class="form-label"
                  ><b>Ciudad *</b></label
                >

                <select
                  class="form-select"
                  id="municipio"
                  v-model="veeduria.ciudad"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in ciudades"
                    :key="index"
                    v-text="i.nombre"
                    :value="i.id"
                  ></option>
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
                  v-model="veeduria.fecha_realizacion"
                  required
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="dir" class="form-label"><b>Dirección *</b></label>
                <input
                  type="text"
                  class="form-control"
                  id="dir"
                  v-model="veeduria.direccion"
                  required
                />
              </div>
            </div>
          </div>

          <!-- {{-- Columna 2 --}} -->
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="fecha" class="form-label"
                  ><b>Correo electrónico *</b></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="fecha"
                  v-model="veeduria.correo"
                  required
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="radicado" class="form-label"
                  ><b>Telefono *</b></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="radicado"
                  v-model="veeduria.telefono"
                  maxlength="15"
                  required
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="radicado" class="form-label"
                  ><b>Radicado CNE *</b></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="radicado"
                  v-model="veeduria.radicado"
                  maxlength="50"
                  required
                />
              </div>
            </div>
            <div class="row">
              <label for="" class="form-label"
                ><b>Tipo de archivo *</b></label
              >
              <select
                class="form-select"
                name="type_file"
                v-model="veeduria.type_file"
              >
                <option value="">Seleccione</option>
                <option
                  v-for="(i, index) in type_file"
                  :key="index"
                  :value="i.id"
                  v-text="i.nombre"
                ></option>
              </select>
            </div>
            <div class="row mt-5">
              <div
                class="form-group files border"
                role="button"
                id="box_file"
                @click="box_file"
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
            <div
              class="row mt-3"
              v-for="(i, index) in archivos"
              :key="index"
            >
              <div class="col-10">
                <select
                  class="form-control bg-transparent text-dark"
                  disabled
                  v-model="i.id_tipo_documento"
                >
                  <option
                    v-for="(item, index) in type_file"
                    :key="index"
                    :value="item.id"
                    v-text="item.nombre"
                  ></option>
                </select>
              </div>
              <div class="col-2">
                <button
                  class="btn btn-danger btn-sm"
                  @click="eliminar_archivo(index)"
                >
                  <i class="fa fa-trash fa-md"></i>
                </button>
              </div>
            </div>
            <input
              accept="image/*, .pdf"
              type="file"
              class="d-none"
              id="file"
              @change="upload_file($event)"
            />
          </div>
        </div>
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
                  v-model="integrante.nombre"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="tipo" class="form-label"
                  ><b>Tipo de identificación *</b>
                </label>
                <select class="form-select" id="tipo" v-model="integrante.tipo_identificacion">
                  <option disabled selected value="">Seleccione ...</option>
                  <option v-for="(i, index) in tipoidentificacion" :key="index" :value="i.id" v-text="i.nombre"
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
                  v-model="integrante.identificacion"
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
                  v-model="integrante.correo"
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

        <input type="hidden" name="integrantes" id="cantInt" />
        <div class="d-none" id="intCont"></div>
        <!-- <div class="d-block" id="intCont"></div> -->
        <!-- {{-- Fila 4 --}} -->
        <div class="row mt-5 justify-content-center">
          <button
            class="btn btn-secondary btn-block active w-50"
            type="button"
            @click="agregar_integrante"
          >
            Agregar integrante
          </button>
        </div>

        <div class="col mt-4">
          <div
            class="row cont_int"
            v-for="(i, index) in integrantes"
            :key="index"
          >
            <div class="col-10 mt-3">{{ i.nombre }}</div>
            <div class="col-1">
              <button
                type="button"
                class="btn btn-sm btn-eye"
                @click="abrir_modal_integrante(index)"
              >
                <span class="iconify" data-icon="cil:locomotive"></span>
                <i class="typcn typcn-eye-outline"></i>
              </button>
            </div>
            <div class="col-1">
              <a
                type="button"
                class="btn btn-sm update_parameterization"
                @click="editar_integrante(index)"
              >
                <i class="typcn typcn-edit"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- {{-- Fila 5 --}} -->
        <div class="row mt-5 justify-content-center">
          <button
            class="btn btn-secondary btn-block active w-50"
            type="button"
            @click="crear_veeduria"
          >
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
              @click="cerrar_modal"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row mb-2">
              <h5 class="modal-title">Integrante</h5>
              <div class="row m-3">
                <div class="col">
                  <div class="row text-style">Nombres y apellidos</div>
                  <div class="row mb-3" id="mNombre">
                    {{ ver_integrante.nombre }}
                  </div>
                  <!-- <div class="row text-style">Tipo de identificación</div> -->
                  <!-- <div class="row mb-3" id="mTipo">{{ ver_integrante.identificacion }}</div> -->
                  <div class="row text-style">Número de identificación</div>
                  <div class="row mb-3" id="mNumeroI">
                    {{ ver_integrante.identificacion }}
                  </div>
                  <div class="row text-style">Dirección</div>
                  <div class="row" id="mDirecc">
                    {{ ver_integrante.direccion }}
                  </div>
                </div>
                <div class="col">
                  <div class="row text-style">Teléfono</div>
                  <div class="row mb-3" id="mTel">
                    {{ ver_integrante.telefono }}
                  </div>
                  <div class="row text-style">Correo electrónico</div>
                  <div class="row mb-3" id="mCorreo">
                    {{ ver_integrante.correo }}
                  </div>
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
      departamentos: [],
      ciudades: [],
      type_file: [],
      tipoidentificacion: [],
      usados: [],
      tipo_veeduria: [],
      integrantes: [],
      integrante: {
        nombre: "",
        tipo_identificacion: "",
        identificacion: "",
        direccion: "",
        telefono: "",
        correo: "",
      },
      ver_integrante: {
        nombre: "",
        tipo_identificacion: "",
        identificacion: "",
        direccion: "",
        telefono: "",
        correo: "",
      },
      veeduria: {
        nombre: "",
        descripcion: "",
        departamento: "",
        ciudad: "",
        fecha_realizacion: "",
        radicado: "",
        direccion: "",
        correo: "",
        telefono: "",
        tipo_veeduria: "",
        type_file: "",
      },
      tipo_archivo: [],
      archivo: { tipo_archivo: "" },
    };
  },
  created() {
    let url = this.ruta + "/nueva_veeduria_data";
    axios.post(url).then((res) => {
      this.departamentos = res.data.departamentos;
      this.tipoidentificacion = res.data.tipoidentificacion;
      this.type_file = res.data.tipodocumentos;
      this.tipo_veeduria = res.data.tipo_veeduria;
    });
  },
  methods: {
      regresar(){
          this.$emit('pantalla', 'listado')
      },
    abrir_modal_integrante(index) {
      this.ver_integrante = this.integrantes[index];
      $("#modal_integrante").modal("show");
    },
    cerrar_modal() {
      $("#modal_integrante").modal("hide");
    },
    agregar_integrante() {
      if (
        this.integrante.nombre == "" ||
        this.integrante.tipo_identificacion == "" ||
        this.integrante.identificacion == "" ||
        this.integrante.direccion == "" ||
        this.integrante.telefono == "" ||
        this.integrante.correo == ""
      ) {
        Swal.fire("¡Error!", "Completa todos los campos", "error");
        return;
      }
      this.integrantes.push(this.integrante);
      this.integrante = {
        nombre: "",
        tipo_identificacion: "",
        identificacion: "",
        direccion: "",
        telefono: "",
        correo: "",
      };
    },
    ciudadesxdep(i) {
      let url = this.ruta + "/munxdep/" + i;
      axios.post(url).then((res) => {
        this.ciudades = res.data.ciudades;
      });
    },
    editar_integrante(index) {
      if (
        this.integrante.nombre == "" &&
        this.integrante.tipo_identificacion == "" &&
        this.integrante.identificacion == "" &&
        this.integrante.direccion == "" &&
        this.integrante.telefono == "" &&
        this.integrante.correo == ""
      ) {
        this.integrante = this.integrantes[index];
        this.integrantes.splice(index, 1);
      } else {
        Swal.fire(
          "¡Advertencia!",
          "Limpia los campos para editar un integrante",
          "warning"
        );
      }
    },
    crear_veeduria() {
      // console.log(this.veeduria);
      // return
    //   if (this.archivos.length == 0) {
    //     Swal.fire("¡Advertencia!", "Carga por lo menos un archivo", "warning");
    //     return;
    //   }
      var formulario = new FormData();
      formulario.append("nombre_tema", this.veeduria.nombre);
      formulario.append("descripcion", this.veeduria.descripcion);
      formulario.append("dep_id", this.veeduria.departamento);
      formulario.append("ciu_id", this.veeduria.ciudad);
      formulario.append("radicado_CNE", this.veeduria.radicado);
      formulario.append("fecha_realizacion", this.veeduria.fecha_realizacion);
      formulario.append("descripcion", this.veeduria.descripcion);
      formulario.append("direccion", this.veeduria.direccion);
      formulario.append("telefono", this.veeduria.telefono);
      formulario.append("tipo_veeduria", this.veeduria.tipo_veeduria);
      formulario.append("correo", this.veeduria.correo);
      for (let index = 0; index < this.archivos.length; index++) {
        formulario.append("archivo" + index, this.archivos[index]);
      }
      for (let index = 0; index < this.integrantes.length; index++) {
        formulario.append(
          "integrante_nombre" + index,
          this.integrantes[index].nombre
        );
        formulario.append(
          "integrante_tipo_identificacion" + index,
          this.integrantes[index].tipo_identificacion
        );
        formulario.append(
          "integrante_identificacion" + index,
          this.integrantes[index].identificacion
        );
        formulario.append(
          "integrante_direccion" + index,
          this.integrantes[index].direccion
        );
        formulario.append(
          "integrante_telefono" + index,
          this.integrantes[index].telefono
        );
        formulario.append(
          "integrante_correo" + index,
          this.integrantes[index].correo
        );
      }
      formulario.append("cantidad", this.archivos.length);
      formulario.append("cantidad_integrantes", this.integrantes.length);
      for (let index = 0; index < this.tipo_archivo.length; index++) {
        formulario.append("tipo_archivo" + index, this.tipo_archivo[index].id);
      }

      for (let index = 0; index < this.archivos.length; index++) {
        formulario.append("archivo" + index, this.archivos[index]);
      }

      let url = this.ruta + "/insertar_veeduria";
      axios.post(url, formulario).then((res) => {
        if (res.data.status == 200) {
          Swal.fire("¡Agregado!", res.data.msg, "success").then(function () {
            location.reload();
          });
        } else if (res.data.status == 406) {
          Swal.fire("¡Error!", res.data.msg, "error");
        }
      });
    },
    box_file() {
      if (this.veeduria.type_file != "") {
        $("#file").trigger("click");
      } else {
        Swal.fire("¡Error!", "Selecciona un tipo de archivo", "error");
      }
    },
    upload_file(event) {
      this.archivo = event.target.files[0];
      this.archivo.id_tipo_documento = this.veeduria.type_file;
      this.tipo_archivo.push({ id: this.veeduria.type_file });
      this.archivos.push(this.archivo);
      this.veeduria.type_file = "";
    },
    eliminar_archivo(index) {
      this.tipo_archivo.splice(index, 1);
      this.archivos.splice(index, 1);
    },
    regresar(){
        this.$emit('pantalla', 'listado')
    }
  },
};
</script>

<style>
.typcn {
  color: rgb(41, 41, 228);
}
.cont_int {
  background: rgb(209, 208, 208);
}
</style>
