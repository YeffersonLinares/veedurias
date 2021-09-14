<template>
  <div class="main col-12">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
      integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp"
      crossorigin="anonymous"
    />


    <!-- // Lista de veedurías -->
    <template v-if="pantalla == 'listado'">
      <div class="container mt-5 rounded-3">
        <label for="" class="p-2">Veedurías/listado de Veedurías</label>
        <div class="row p-2 text-center border shadow">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-9 col-xl-9 p-2">
              <h1 class="text-blue"><b>VEEDURÍAS</b></h1>
            </div>
            <div class="col-12 col-md-12 col-lg-3 col-xl-3 p-2">
              <button
                type="button"
                class="btn btn-warning text-white w-100 mt-2"
                @click="nueva_veeduria"
              >
                Nueva veeduría
              </button>
            </div>
          </div>
        </div>
        <form class="row mt-5" id="form_buscar_lista_veedurias">
          <div class="mb-3 col-3">
            <label for="" class="form-label">Nombre</label>
            <input
              maxlength="50"
              type="text"
              class="form-control"
              v-model="filtros.nombre"
            />
          </div>
          <div class="mb-3 col-3">
            <label for="" class="form-label">Departamento</label>
            <select
              type="text"
              class="form-select"
              v-model="filtros.departamento"
            >
              <option value="">Selecciona</option>
              <option
                v-for="(i, index) in departamentos"
                :key="index"
                :value="i.id"
                v-text="i.nombre"
              ></option>
            </select>
          </div>
          <div class="mb-3 col-3">
            <label for="" class="form-label">Tipo de veeduría</label>
            <select class="form-select" v-model="filtros.tipo">
                <option value="">Seleccione</option>
                <option v-for="(i,index) in tipo_veeduria" :key="index" :value="i.id" v-text="i.nombre"></option>
            </select>
          </div>

          <div class="mb-3 col-3 mt-4">
            <button
              type="button"
              class="btn btn-secondary btn-block active mt-2"
              @click="filtrar"
            >
              Buscar
            </button>
          </div>
        </form>
      </div>
      <!-- <div class="container table-responsive"> -->
        <table
          class="table table-bordered table-striped table-sm" style="width:120%; margin-left:-100px; margin-top:20px"
          id="lista_veeduria_table"
        >
          <thead>
            <tr>
              <th style="width:22%">Opciones</th>
              <th style="width:20%">Nombre</th>
              <th style="width:20%">Descripción</th>
              <th style="width:10%">Departamento</th>
              <th style="width:10%">Municipio</th>
              <th style="width:10%">Tipo de veeduría</th>
              <th style="width:8%">Fecha</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(i, index) in veedurias" :key="index">
              <td>
                    <button
                      type="button"
                      class="btn btn-success btn-sm"
                      @click="detalles_veeduria(i)"
                    >
                    <i class="typcn typcn-eye" style="color: white"></i>
                    </button>
                    <button
                      type="button"
                      class="btn btn-warning btn-sm"
                      @click="editar_veeduria(i)"
                    >
                      <i class="typcn typcn-edit" style="color: white"></i>
                    </button>
                    <button
                      type="button"
                      class="btn btn-info btn-sm"
                      @click="documentoxveeduria(i)"
                    >
                      <i
                        class="typcn typcn-download-outline" style="color: white"
                      ></i>
                    </button>
                    <button
                      type="button"
                      class="btn btn-danger btn-sm"
                      @click="modal_eliminar(i, index)"
                    >
                      <i class="typcn typcn-trash" style="color: white"></i>
                    </button>
              </td>
              <td>{{ i.nombre_tema }}</td>
              <td>{{ i.descripcion }}</td>
              <td v-if="i.dep_nombre != null">{{ i.dep_nombre }}</td>
              <td v-else>No aplica</td>
              <td v-if="i.ciu_nombre != null">{{ i.ciu_nombre }}</td>
              <td v-else>No aplica</td>
              <td>{{ i.tipo_nombre }}</td>
              <td>{{ i.fecha_realizacion }}</td>
            </tr>
          </tbody>
        </table>
      <!-- </div> -->
      <div
        class="modal fade"
        id="modal_eliminar"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                Eliminar veeduría
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              ¿Estás seguro de eliminar esta veeduría?
            </div>
            <div class="modal-footer">
              <form>
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-bs-dismiss="modal"
                >
                  No
                </button>
                <button type="submit" class="btn btn-danger">Si</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Inicio modal descargar archivos -->

      <div
        class="modal fade"
        id="modal_download"
        aria-hidden="true"
        aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1"
      >
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalToggleLabel2">
                Veedurías ciudadanas
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                @click="cerrar_modal_download"
              ></button>
            </div>
            <div class="modal-body">
              <div
                class="row container mb-2"
                v-for="(i, index) in documentos"
                :key="index"
              >
                <div class="col-10">
                  <!-- <select class="form-select" id="tipo" disabled></select> -->
                  <input
                    type="text"
                    class="form-control"
                    disabled
                    :value="i.tipo_nombre"
                  />
                </div>
                <div class="col-2">
                  <a
                    class="btn-self btn btn-warning text-white"
                    :download="i.ruta"
                    :href="i.ruta"
                  >
                    <i class="typcn typcn-download cl-white"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Fin modal descargar archivos -->
    </template>

    <template v-if="pantalla == 'nueva_veeduria'">
      <div>
        <nueva-veeduria @pantalla="pantalla = $event" :ruta="ruta2"/>
      </div>
    </template>

    <template v-if="pantalla == 'detalles_veeduria'">
      <div>
        <detalles-veeduria @pantalla="pantalla = $event" :id="id" :ruta="ruta2" />
      </div>
    </template>

    <template v-if="pantalla == 'editar_veeduria'">
      <div>
        <editar-veeduria @pantalla="pantalla = $event" :id="id" :ruta="ruta2" />
      </div>
    </template>

    <!-- Inicio modal eliminar veeduría -->
    <div
      class="modal fade"
      id="modal_eliminar_veeduria"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Eliminar veeduría
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              @click="cerrar_modal_eliminar"
            ></button>
          </div>
          <div class="modal-body">¿Está seguro de eliminar esta veeduría?</div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
              @click="cerrar_modal_eliminar"
            >
              No
            </button>
            <button
              type="button"
              class="btn btn-danger"
              @click="destroy_veeduria"
            >
              Si
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin modal eliminar veeduría -->
  </div>
</template>



<script>
export default {
props : ['ruta','pie'],
  data() {
    return {
      documentos: [],
      veedurias: [],
      tipo_veeduria: [],
      filtros: { nombre: "", departamento: "", tipo: "" },
      departamentos: [],
      eliminar: { id: "", index: "" },
      pantalla: "listado",
    //   pantalla: "nueva_veeduria",
      id: 1,
      ruta2: this.ruta
    };
  },
  created() {
    let url = this.ruta + "/lista_veeduria_data";
    axios.get(url).then((res) => {
      this.veedurias = res.data.veedurias;
      this.departamentos = res.data.departamentos;
      this.tipo_veeduria = res.data.tipo_veeduria
      this.formatear_fecha();
    });
  },
  methods: {
    filtrar() {
      let url = this.ruta + "/filtrar_lista_veeduria";
      axios.post(url, this.filtros).then((res) => {
        this.veedurias = res.data.veeduria;
        this.formatear_fecha();
      });
    },
    formatear_fecha() {
      var fechas = "";
      var fecha_format = "";
      var array = [];
      for (let index = 0; index < this.veedurias.length; index++) {
        fechas = this.veedurias[index].fecha_realizacion;
        array = fechas.split("-");
        fecha_format = array[2] + "-" + array[1] + "-" + array[0];
        this.veedurias[index].fecha_realizacion = fecha_format;
      }
    },
    editar_veeduria(i) {
      this.id = i.id;
      this.pantalla = "editar_veeduria";
    },
    documentoxveeduria(i) {
      let url = this.ruta + "/documentoxveeduria/" + i.id;
      axios.post(url).then((res) => {
        this.documentos = res.data.documentos;
        if (this.documentos.length == 0) {
          Swal.fire(
            "¡Advertencia!",
            "Esta veeduría no tiene documentos cargados",
            "warning"
          );
        } else {
          $("#modal_download").modal("show");
        }
      });
    },
    cerrar_modal_download() {
      $("#modal_download").modal("hide");
    },
    nueva_veeduria() {
      this.pantalla = "nueva_veeduria";
    },
    cerrar_modal_eliminar() {
      $("#modal_eliminar_veeduria").modal("hide");
    },
    detalles_veeduria(i) {
      this.id = i.id;
      this.pantalla = "detalles_veeduria";
    },
    modal_eliminar(i, index) {
      this.eliminar.id = i.id;
      this.eliminar.index = index;
      $("#modal_eliminar_veeduria").modal("show");
    },
    destroy_veeduria() {
      let url = this.ruta + "/eliminar_veeduria/" + this.eliminar.id;
      axios.post(url).then((res) => {
        setTimeout(function () {
          $("#modal_eliminar_veeduria").modal("hide");
        }, 500);
        Swal.fire("¡Éxito!", "Veeduría eliminada con éxito", "success");
        this.veedurias.splice(this.eliminar.index, 1);
        this.eliminar = { id: "", index: "" };
      });
    },
  },
};
</script>
