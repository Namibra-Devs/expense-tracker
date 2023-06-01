class Alert {
	modalBox = document.getElementById("modal");

	constructor() {
		// this.element = element
		this.openModal();
	}

	openModal() {
		this.modalBox.classList.add("show");
		// this.closeBtn.onclick = () => {
		//     this.closeModal()
		// }
	}

	closeModal() {
		const child = document.querySelector(".card");
		this.modalBox.removeChild(child);
		this.modalBox.classList.remove("show");
	}

	confirmBox(text, callback) {
		this.modalBox.innerHTML = `
        <div class="card shadow-lg">
            <div class="card-header border-0">
                <h2>Confirm</h2>
                <span id="close-modal" class="fs-2">&times;</span>
            </div>
            <div class="card-body">
                <p >${text}</p>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button class="btn btn-danger" id="cancel-btn">Cancel</button>
                <button class="btn btn-primary" id="confirm-btn">Confirm</button>
            </div>
        </div>
        `;
		// this.openModal()
		const cancelBtn = this.modalBox.querySelector("#cancel-btn");
		const confirmBtn = this.modalBox.querySelector("#confirm-btn");
		const closeBtn = this.modalBox.querySelector("#close-modal");

		cancelBtn.onclick = () => {
			this.closeModal();
		};
		closeBtn.onclick = () => {
			this.closeModal();
		};
		confirmBtn.onclick = callback;
	}

	alertBox(text) {
		this.modalBox.innerHTML = `
        <div class="card shadow-lg">
            <div class="card-header bg-white">
                <h2>Alert</h2>
            </div>
            <div class="card-body">
                <p class="fs-6">${text}</p>
            </div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary w-100" id="confirm-btn">Ok</button>
            </div>
        </div>
        `;
		const closeBtn = this.modalBox.querySelector("#confirm-btn");

		closeBtn.onclick = () => {
			this.closeModal();
            this.clearModalTimeOut();

		};

		//close modal on click outside
		window.onclick = (e) => {
			if (e.target === this.modalBox) {
				this.closeModal();

			}
		};

		// close on esc key
		document.onkeydown = (e) => {
			if (e.key === "Escape") {
				this.closeModal();

			}
		};
		// close modal after 3 seconds
		this.setModalTimeOut(() => {
			this.closeModal();
		}, 6000);

        if(!this.modalBox.classList.contains("show")){
            this.clearModalTimeOut()
        }
	}
    

    setModalTimeOut(callback, time) {
        setTimeout(() => {
            callback()
        }, time);
    }
    

    clearModalTimeOut() {
        clearTimeout(this.setModalTimeOut)
    }
}

export default Alert;
