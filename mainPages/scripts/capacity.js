    const roomCapacityMap = {
        "single": 1,
        "double": 2,
        "triple": 3,
        "quad": 4,
        "dormitory": 6,
        "suite": 2
    };

    const roomTypeSelect = document.getElementById("roomType");
    const roomCapacityInput = document.getElementById("roomCapacity");

    //GOT HELP FROM AI
    roomTypeSelect.addEventListener("change", () => {
        const selectedRoomType = roomTypeSelect.value;
        roomCapacityInput.value = roomCapacityMap[selectedRoomType] || "";
});
