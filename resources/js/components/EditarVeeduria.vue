<template>
  <div class="main col-12">
    <div class="container mt-5 mb-5">
      <label for="" class="p-2"
        >Veedurías/Listado de veedurías/Editar veeduría</label
      >
      <div class="row p-2 text-center border shadow">
        <div class="row">
          <div class="col-md-9">
            <h1 class="text-blue"><b>EDITAR VEEDURÍA</b></h1>
          </div>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <button class="btn btn-secondary active btn-block" @click="regresar">
                    Regresar
                </button>
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
                  v-model="veeduria.nombre_tema"
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
                  ><b>Tipo de veeduría</b></label
                >
                <select class="form-select" v-model="veeduria.tipo_id">
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
            <div
              class="row"
              v-if="
                veeduria.tipo_id == '2' ||
                veeduria.tipo_id == '3' ||
                veeduria.tipo_id == '4'
              "
            >
              <div class="mb-3">
                <label for="departamento" class="form-label"
                  ><b>Departamento *</b></label
                >
                <select
                  v-model="veeduria.dep_id"
                  class="form-select"
                  id="departamento"
                  required
                  @change="ciudadesxdep(veeduria.dep_id)"
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
            <div
              class="row"
              v-if="veeduria.tipo_id == '3' || veeduria.tipo_id == '4'"
            >
              <div class="mb-3">
                <label for="municipio" class="form-label"
                  ><b>Ciudad *</b></label
                >

                <select
                  class="form-select"
                  id="municipio"
                  v-model="veeduria.ciu_id"
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
                <label for="fecha" class="form-label"><b>Dirección</b></label>
                <input
                  type="text"
                  class="form-control"
                  id="fecha"
                  v-model="veeduria.direccion"
                  required
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="fecha" class="form-label"
                  ><b>Correo electrónico</b></label
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
          </div>

          <!-- {{-- Columna 2 --}} -->
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="radicado" class="form-label"><b>Teléfono</b></label>
                <input
                  type="text"
                  class="form-control"
                  id="radicado"
                  v-model="veeduria.telefono"
                  maxlength="50"
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
                <select class="form-select" id="tipoArchivo" name="tipoArchivo" v-model="veeduria.type_file">
                  <option selected value="">Seleccione ...</option>
                  <option v-for="(i, index) in type_file" :key="index" :value="i.id" v-text="i.nombre"></option>
                </select>
              </div>
            </div>

            <div class="row mt-5">
              <div
                class="form-group files border"
                role="button"
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
            <div class="row mb-3">
              <div class="row mb-3" v-for="(i, index) in archivos" :key="index">
                <div class="col-10">
                  <select
                    class="form-control bg-transparent text-dark"
                    disabled
                    v-model="i.id_tipo_documento"
                  >
                    <option
                      v-for="(item, index) in archivos"
                      :key="index"
                      :value="item.id"
                      v-text="item.tipo_nombre"
                    ></option>
                  </select>
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
          id="file"
          accept=".pdf, .png, .jpg, .xls"
          @change="upload_file($event)"
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
                  v-model="integrante.nombre"
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
                  v-model="integrante.id_tipo_identificacion"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in tipoIdentificacion"
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
                  v-model="integrante.documento"
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

        <input type="hidden" name="integrantes" id="cantInt" />
        <div class="d-none" id="intCont"></div>
        <!-- <div class="d-block" id="intCont"></div> -->
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
            Guardar cambios
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
                    {{ ver_integrante.documento }}
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
                    {{ ver_integrante.email }}
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
  props: ["id",'ruta'],
  data() {
    return {
      tipoIdentificacion: [],
      departamentos: [],
      ciudades: [],
      integrantes: [],
      archivos_eliminados: [],
      type_file: [],
      usados: [],
      tipo_veeduria: [],
      integrante: {
        id: "",
        nombre: "",
        id_tipo_identificacion: "",
        documento: "",
        direccion: "",
        telefono: "",
        email: "",
      },
      ver_integrante: {
        id: "",
        nombre: "",
        id_tipo_identificacion: "",
        documento: "",
        direccion: "",
        telefono: "",
        email: "",
      },
      veeduria: {
        nombre_tema: "",
        descripcion: "",
        dep_id: "",
        ciu_id: "",
        fecha_realizacion: "",
        radicado_CNE: "",
        type_file: "",
      },
      archivos: [],
      tipo_archivo: [],
      archivo: { tipo_archivo: "" },
      index: 0,
    };
  },
  created() {
    let url = this.ruta +"/edit_veeduria/" + this.id;
    // let url = "/edit_veeduria/3";
    axios.get(url).then((res) => {
      this.veeduria = res.data.veeduria;
      this.veeduria["tipo_archivo"] = "";
      this.integrantes = res.data.integrantes;
      this.departamentos = res.data.departamentos;
      this.ciudades = res.data.ciudades;
      this.archivos = res.data.archivos;
      this.tipoIdentificacion = res.data.tipoIdentificacion;
      this.type_file = res.data.tipoDocumentos;
      this.tipo_veeduria = res.data.tipo_veeduria;
      for (let index = 0; index < this.archivos.length; index++) {
        this.usados.push(this.archivos[index].id_tipo_documento);
      }
      let url = this.ruta +"/munxdep/" + this.veeduria.dep_id;
      axios.post(url).then((res) => {
        this.ciudades = res.data.ciudades;
      });
    });
  },
  methods: {
    regresar() {
      this.$emit("pantalla", "listado");
    },
    abrir_modal_integrante(index) {
      this.ver_integrante = this.integrantes[index];
      console.log(this.ver_integrante);
      $("#modal_integrante").modal("show");
    },
    cerrar_modal() {
      $("#modal_integrante").modal("hide");
    },
    agregar_integrante() {
      if (
        this.integrante.nombre == "" ||
        this.integrante.id_tipo_identificacion == "" ||
        this.integrante.documento == "" ||
        this.integrante.direccion == "" ||
        this.integrante.telefono == "" ||
        this.integrante.email == ""
      ) {
        Swal.fire("¡Error!", "Completa todos los campos", "error");
        return;
      }
      this.integrantes.push(this.integrante);
      this.integrante = {
        id: "",
        nombre: "",
        id_tipo_identificacion: "",
        documento: "",
        direccion: "",
        telefono: "",
        email: "",
      };
    },
    ciudadesxdep(i) {
      let url = this.ruta +"/munxdep/" + i;
      axios.post(url).then((res) => {
        this.ciudades = res.data.ciudades;
      });
    },
    editar_integrante(index) {
      if (
        this.integrante.nombre == "" &&
        this.integrante.id_tipo_identificacion == "" &&
        this.integrante.documento == "" &&
        this.integrante.direccion == "" &&
        this.integrante.telefono == "" &&
        this.integrante.email == ""
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
      //   if (this.archivos.length == 0) {
      //     Swal.fire("¡Advertencia!", "Carga por lo menos un archivo", "warning");
      //     return;
      //   }
      var formulario = new FormData();
      formulario.append("id", this.id);
      //   formulario.append("id", 3);
      formulario.append("nombre_tema", this.veeduria.nombre_tema);
      formulario.append("descripcion", this.veeduria.descripcion);
      formulario.append("dep_id", this.veeduria.dep_id);
      formulario.append("ciu_id", this.veeduria.ciu_id);
      formulario.append("radicado_CNE", this.veeduria.radicado_CNE);
      formulario.append("fecha_realizacion", this.veeduria.fecha_realizacion);
      formulario.append("descripcion", this.veeduria.descripcion);
      formulario.append("direccion", this.veeduria.direccion);
      formulario.append("telefono", this.veeduria.telefono);
      formulario.append("tipo_veeduria", this.veeduria.tipo_id);
      formulario.append("correo", this.veeduria.correo);
      for (let index = 0; index < this.archivos_eliminados.length; index++) {
        formulario.append(
          "a_eliminados" + index,
          this.archivos_eliminados[index]
        );
      }
      formulario.append("cant_eliminados", this.archivos_eliminados.length);

      for (let index = 0; index < this.archivos.length; index++) {
        formulario.append("archivo" + index, this.archivos[index]);
      }
      for (let index = 0; index < this.integrantes.length; index++) {
        if (this.integrantes[index].id != null) {
          formulario.append("id" + index, this.integrantes[index].id);
        }
        formulario.append(
          "integrante_nombre" + index,
          this.integrantes[index].nombre
        );
        formulario.append(
          "integrante_tipo_identificacion" + index,
          this.integrantes[index].id_tipo_identificacion
        );
        formulario.append(
          "integrante_identificacion" + index,
          this.integrantes[index].documento
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
          this.integrantes[index].email
        );
      }
      formulario.append("cantidad", this.archivos.length);
      formulario.append("cantidad_integrantes", this.integrantes.length);

      for (let index = 0; index < this.tipo_archivo.length; index++) {
        formulario.append("tipo_archivo" + index, this.tipo_archivo[index].id);
      }

      let url = this.ruta +"/update_veeduria";
      axios.post(url, formulario).then((res) => {
        if (res.data.status == 200) {
          Swal.fire("¡Éxito!", res.data.msg, "success").then(function () {
            location.reload();
          });
        } else {
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
    //   for (let index = 0; index < this.usados.length; index++) {
    //     if (this.usados[index] == this.veeduria.tipo_archivo) {
    //       Swal.fire(
    //         "¡Advertencia!",
    //         "Ya usaste este tipo de archivo",
    //         "warning"
    //       );
    //       return;
    //     }
    //   }
      let archivo = { nombre: "", name: "" };
      archivo = event.target.files[0];
      archivo.nombre = archivo.name;
      archivo.id_tipo_documento = this.veeduria.tipo_archivo;
      this.archivos.push(archivo);
      this.usados.push(this.veeduria.tipo_archivo);
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
