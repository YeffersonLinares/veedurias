<template>
  <div class="main col-12">
    <div class="container mt-5 mb-5">
      <label for="" class="p-2"
        >Veedurías/Listado de veedurías/detalles veeduría</label
      >
      <div class="row p-2 text-center border shadow">
        <div class="row">
          <h1 class="text-blue"><b>DETALLES VEEDURÍA</b></h1>
        </div>
      </div>

      <form method="POST" enctype="multipart/form" id="frmVeeduria">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="nombre" class="form-label"> <b>Nombre</b></label>
                <input
                  type="text"
                  class="form-control"
                  maxlength="50"
                  v-model="veeduria.nombre_tema"
                  disabled
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="descripcion" class="form-label"
                  ><b>Descripción</b></label
                >
                <textarea
                  class="form-control"
                  style="height: 150px"
                  maxlength="500"
                  v-model="veeduria.descripcion"
                  disabled
                ></textarea>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="departamento" class="form-label"
                  ><b>Departamento</b></label
                >
                <select
                  v-model="veeduria.dep_id"
                  disabled
                  class="form-select"
                  id="departamento"
                  required
                >
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
                <label for="fecha" class="form-label"><b>Dirección</b></label>
                <input
                  type="text"
                  class="form-control"
                  id="fecha"
                  v-model="veeduria.direccion"
                  disabled
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
                  disabled
                  required
                />
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="radicado" class="form-label"
                  ><b>Teléfono</b></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="radicado"
                  v-model="veeduria.telefono"
                  disabled
                  maxlength="50"
                  required
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="radicado" class="form-label"
                  ><b>Tipo de veeduría</b></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="radicado"
                  v-model="veeduria.tipo_id"
                  disabled
                  maxlength="50"
                  required
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="radicado" class="form-label"
                  ><b>Radicado CNE</b></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="radicado"
                  v-model="veeduria.radicado_CNE"
                  disabled
                  maxlength="50"
                  required
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="municipio" class="form-label"><b>Ciudad</b></label>

                <select
                  class="form-select"
                  id="municipio"
                  v-model="veeduria.ciu_id"
                  disabled
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
                  ><b>Fecha de creación</b></label
                >
                <input
                  type="date"
                  class="form-control"
                  id="fecha"
                  v-model="veeduria.fecha_realizacion"
                  disabled
                  required
                />
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col sub-title"><b>Integrantes</b></div>
        </div>

        <div class="col mt-4">
          <div
            class="row cont_int"
            v-for="(i, index) in integrantes"
            :key="index"
          >
            <div class="col-10 mt-3">{{ i.nombre }}</div>
            <div class="col-2">
              <button
                type="button"
                class="btn btn-sm btn-eye"
                @click="abrir_modal_integrante(index)"
              >
                <span class="iconify" data-icon="cil:locomotive"></span>
                <i class="typcn typcn-eye-outline"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-3">
            <button
              class="btn btn-secondary active btn-block"
              @click="regresar"
            >
              Regresar
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
  props: ["id"],
  data() {
    return {
      departamentos: [],
      ciudades: [],
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
      },
    };
  },
  created() {
    let url = "/detalles_veeduria/" + this.id;
    axios.get(url).then((res) => {
        console.log(res.data);
      this.veeduria = res.data.veeduria;
      this.integrantes = res.data.integrantes;
      this.departamentos = res.data.departamentos;
      this.ciudades = res.data.ciudades;
    });
  },
  methods: {
    abrir_modal_integrante(index) {
      this.ver_integrante = this.integrantes[index];
      $("#modal_integrante").modal("show");
    },
    cerrar_modal() {
      $("#modal_integrante").modal("hide");
    },
    regresar() {
      this.$emit("pantalla", "listado");
    },
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
input,textarea,select:disabled{
    background: #fff !important;
}
</style>
