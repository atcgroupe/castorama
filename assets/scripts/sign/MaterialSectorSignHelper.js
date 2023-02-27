import { FormHelper } from "../app/form_helper";

export class MaterialSectorSignHelper {
  constructor(formName) {
    this.formName = formName;
    this.maxAisleNumber = 999;

    this.previewOne = document.getElementById("material-sector-sign-1");
    this.previewTwo = document.getElementById("material-sector-sign-2");
    this.previewsSector = document.getElementsByClassName(`sector-value`);
    this.previewsAisleNumber =
      document.getElementsByClassName("aisle-number-value");

    this.aisleNumberInput = document.getElementById(`${formName}_aisleNumber`);
    this.alignmentSelect = document.getElementById(`${formName}_alignment`);
    this.itemsSectorSelect = document.getElementById(`${formName}_sector`);
    this.itemsSelects = document.getElementsByClassName("item_select");

    this.refreshSignPreview();
    this.addAisleNumberListener();
    this.addAlignmentListener();
    this.addSectorListener();
  }

  setPreviewNumber() {
    if (this.aisleNumberInput.value >= this.maxAisleNumber) {
      this.aisleNumberInput.value = this.maxAisleNumber;
    }

    Array.from(this.previewsAisleNumber).forEach((item) => {
      item.innerText = this.aisleNumberInput.value;
    });
  }

  setPreviewAlignment() {
    const alignment = this.alignmentSelect.value;

    if (alignment === "all") {
      this.previewOne.classList.remove("right");
      this.previewOne.classList.add("left");
      this.previewTwo.classList.remove("left");
      this.previewTwo.classList.add("right");
      return;
    }

    if (alignment === "left") {
      this.previewOne.classList.remove("right");
      this.previewOne.classList.add("left");
      return;
    }

    if (alignment === "right") {
      this.previewOne.classList.remove("left");
      this.previewOne.classList.add("right");
    }
  }

  setPreviewsScale() {
    if (this.alignmentSelect.value === "all") {
      this.previewOne.classList.remove("large");
      this.previewOne.classList.add("medium");
      return;
    }

    this.previewOne.classList.remove("medium");
    this.previewOne.classList.add("large");
  }

  setPreviewsVisibility() {
    if (this.alignmentSelect.value === "all") {
      this.previewTwo.classList.remove("d-none");
      return;
    }

    this.previewTwo.classList.add("d-none");
  }

  setPreviewSector() {
    Array.from(this.previewsSector).forEach((sector) => {
      if (!this.itemsSectorSelect.value) {
        sector.innerText = "";

        return;
      }

      const sectorValue =
        this.itemsSectorSelect.options[this.itemsSectorSelect.selectedIndex]
          .text;
      sector.innerText = sectorValue;

      if (sectorValue.split(" ").some((elem) => elem.length > 13)) {
        sector.classList.add("stretch");
        sector.classList.remove("normal");
        return;
      }

      sector.classList.add("normal");
      sector.classList.remove("stretch");
    });
  }

  isOptionEmpty(dataSelect) {
    const option = dataSelect.options[dataSelect.selectedIndex];

    return typeof option === "undefined" || option.text === "";
  }

  enableElement(element) {
    element.removeAttribute("disabled");
  }

  refreshSignPreview() {
    this.setPreviewsVisibility();
    this.setPreviewsScale();
    this.setPreviewNumber();
    this.setPreviewAlignment();
    this.setPreviewSector();
  }

  addAisleNumberListener() {
    this.aisleNumberInput.addEventListener("change", () =>
      this.setPreviewNumber()
    );
  }

  addAlignmentListener() {
    this.alignmentSelect.addEventListener("change", () => {
      this.setPreviewsVisibility();
      this.setPreviewsScale();
      this.setPreviewAlignment();
    });
  }

  addSectorListener() {
    this.itemsSectorSelect.addEventListener("change", () =>
      this.setPreviewSector()
    );
  }
}
