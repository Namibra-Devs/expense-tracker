import Alert from "./Alert.js";

const DELETEBTN = document.querySelectorAll(".delBtn");

DELETEBTN.forEach((btn) => {
	btn.addEventListener("click", (e) => {
		const ID = e.target.dataset.expenseid;

		// console.log(ID);
		const modal = new Alert();
		modal.confirmBox(
			"Are you sure you want to delete this? This process is not reversible.",
            () => {
				window.location.href = `./processes/delete.proc.php?id=${ID}`;
            }
		);
	});
});
