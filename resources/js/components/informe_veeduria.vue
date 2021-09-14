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
    <div class="container mt-5 rounded-3">
      <label for="" class="p-2">Veedurías/Informes de Veedurías</label>
      <div class="row p-2 text-center border shadow">
        <div class="row">
          <h1 class="text-blue"><b>INFORME DE VEEDURÍA</b></h1>
        </div>
      </div>
      <form @submit.prevent="filtrar" class="row mt-5">
        <div class="mb-3 col-3">
          <label for="" class="form-label">Nombre</label>
          <input
            type="text"
            class="form-control"
            id=""
            v-model="veeduria.tema"
          />
        </div>
        <div class="mb-3 col-3">
          <label for="" class="form-label">Descripción</label>
          <input
            type="text"
            class="form-control"
            id=""
            v-model="veeduria.descripcion"
          />
        </div>
        <div class="mb-3 col-3">
          <label for="" class="form-label">Departamento</label>
          <select class="form-select" v-model="veeduria.departamento">
            <option value="">Seleccione...</option>
            <option
              v-for="(i, index) in departamentos"
              :key="index"
              :value="i.id"
              v-text="i.nombre"
            ></option>
          </select>
        </div>
        <div class="mb-3 col-3">
          <label for="" class="form-label">Municipio</label>
          <select class="form-select" v-model="veeduria.municipio">
            <option value="">Seleccione...</option>
            <option
              v-for="(i, index) in municipios"
              :key="index"
              :value="i.id"
              v-text="i.nombre"
            ></option>
          </select>
        </div>
        <div class="row mt-2 mb-4">
          <div class="mb-3 col-3">
            <label for="" class="form-label">Tipo de veeduría</label>
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
          <div class="mb-3 col-3">
            <label for="" class="form-label">Fecha inicial</label>
            <input
              type="date"
              class="form-control"
              id=""
              name="fecha"
              v-model="veeduria.fecha_desde"
            />
          </div>
          <div class="mb-3 col-3">
            <label for="" class="form-label">Fecha final</label>
            <input
              type="date"
              class="form-control"
              id=""
              name="fecha"
              v-model="veeduria.fecha_hasta"
            />
          </div>
          <!-- <div class="mb-3 col-3">
            <label for="" class="form-label">Estado veeduría</label>
            <select class="form-select" v-model="veeduria.estado">
                <option value="">Seleccione</option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
          </div> -->
          <div class="col-3 mt-4">
            <button
              type="submit"
              class="btn btn-secondary active btn-block mt-2"
            >
              Buscar
            </button>
          </div>
        </div>
      </form>
    </div>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0"
      crossorigin="anonymous"
    />
    <div class="container mb-4">
      <div class="row justify-content-end">
        <div class="col-11"></div>
        <div class="col-1">
          <button
            href="javascript:"
            class="btn btn-success w-100px btn_excel"
            @click="informe" title="Imprimir Reporte"
          >
            <i class="fas fa-file-excel icons_v"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="container mt-1">
      <table
        class="table table-bordered table-striped table-sm mt-5 text-center"
        id="informeVeeduria"
      >
        <thead>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Departamento</th>
          <th>Municipio</th>
          <th>Fecha</th>
          <!--  <th>Tipo de veeduría</th> -->
          <th>Opciones</th>
        </thead>
        <tbody id="tvedurias">
          <tr v-for="(i, index) in veedurias" :key="index">
            <td v-text="i.nombre_tema"></td>
            <td v-text="i.descripcion"></td>
            <td v-if="i.dep_nombre != null">{{ i.dep_nombre }}</td>
            <td v-else>No aplica</td>
            <td v-if="i.ciu_nombre != null">{{ i.ciu_nombre }}</td>
            <td v-else>No aplica</td>
            <td v-text="i.fecha_realizacion"></td>
            <!-- <td v-text="i.tipo_nombre"></td> -->
            <td class="aling_btn_options w-20">
              <button
                class="btn btn-secondary active btn-sm"
                @click="abrir_modal_pdf(i)" title="Generar Certificación"
              >
                <i class="fas fa-download icons_v"></i>
                <!-- <span class="ms-2"> Descargar informe </span> -->
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="row mt-2 mb-4">
        <div class="col-sm-4"></div>
        <div class="col-sm-4"></div>
        <div class="col-sm-4"></div>
      </div>
    </div>

    <!-- Abrir modal exportar pdf -->

    <div
      class="modal fade"
      id="modal_pdf"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Descargar Certificación
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              @click="cerrar_modal_pdf"
            ></button>
          </div>
          <div class="modal-body">
            <form>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label"
                  >Radicado</label
                >
                <input
                  type="text"
                  class="form-control"
                  id="recipient-name"
                  v-model="pdf.radicado"
                />
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label"
                  >Proyectó</label
                >
                <input
                  type="text"
                  class="form-control"
                  id="recipient-name"
                  v-model="pdf.proyecto"
                />
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label"
                  >Revisó</label
                >
                <input
                  type="text"
                  class="form-control"
                  id="recipient-name"
                  v-model="pdf.reviso"
                />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
              @click="cerrar_modal_pdf"
            >
              Cerrar
            </button>
            <button type="button" class="btn btn-primary" @click="exportPdf">
              Generar
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Cerrar modal exportar pdf -->
  </div>
</template>

<script>
export default {
  props: ['ruta'],
  data() {
    return {
      veedurias: [],
      departamentos: [],
      tipo_veeduria: [],
      municipios: [],
      veeduria: {
        tema: "",
        descripcion: "",
        departamento: "",
        municipio: "",
        fecha_desde: "",
        fecha_hasta: "",
        tipo_veeduria: "",
      },
      municiposx: [],
      departamentosx: [],
      pdf: { id: 0, radicado: "", proyecto: "", reviso: "" },
    };
  },
  created() {
    let url = this.ruta + "/informe_veeduria/data";
    axios.post(url).then((res) => {
      this.veedurias = res.data.veeduria;
      this.departamentos = res.data.departamentos;
      this.municipios = res.data.municipios;
      this.tipo_veeduria = res.data.tipo_veeduria;
      var fechas = "";
      var fecha_format = "";
      var array = [];
      for (let index = 0; index < this.veedurias.length; index++) {
        fechas = this.veedurias[index].fecha_realizacion;
        array = fechas.split("-");
        fecha_format = array[2] + "-" + array[1] + "-" + array[0];
        this.veedurias[index].fecha_realizacion = fecha_format;
      }
    });
  },
  methods: {
    filtrar() {
        let filtros = this.veeduria;
        console.log(filtros);
      let url = this.ruta + "/filtrar_veeduria";
      //   console.log(filtros);
      axios.post(url, filtros).then((res) => {
        console.log(res.data);
        this.veedurias = res.data.veeduria;
        var fechas = "";
        var fecha_format = "";
        var array = [];
        for (let index = 0; index < this.veedurias.length; index++) {
          fechas = this.veedurias[index].fecha_realizacion;
          array = fechas.split("-");
          fecha_format = array[2] + "-" + array[1] + "-" + array[0];
          this.veedurias[index].fecha_realizacion = fecha_format;
        }
      });
    },
    informe() {
      let url = this.ruta + "/excel-veeduria";
      let filtros = this.veeduria;
      axios.post(url, filtros).then((res) => {
        //   console.log(res.data);
        //   return
        let blob = new Blob([res.data]);
        let link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = "ReporteVeeduria.xls";
        link.click();
      });
    },
    abrir_modal_pdf(i) {
      this.pdf = { id: 0, radicado: "", proyecto: "", reviso: "" };
      this.pdf.id = i.id;
      $("#modal_pdf").modal("show");
    },
    cerrar_modal_pdf() {
      $("#modal_pdf").modal("hide");
    },
    exportPdf(i) {
      // console.log(this.pdf);
      // return
      if (
        this.pdf.radicado == "" ||
        this.pdf.proyecto == "" ||
        this.pdf.reviso == ""
      ) {
        Swal.fire("¡Advertencia!", "Completa todos los campos", "warning");
      } else {
        window.open(this.ruta +
          "/download?id=" +
            this.pdf.id +
            "&radicado=" +
            this.pdf.radicado +
            "&proyecto=" +
            this.pdf.proyecto +
            "&reviso=" +
            this.pdf.reviso
        );
        $("#modal_pdf").modal("hide");
      }
    },
  },
};
</script>

<style>
tr > td {
  height: 55px;
}

.icons_v {
  font-size: 1rem !important;
  position: relative !important;
  bottom: 0px !important;
  right: 0px !important;
}
</style>
