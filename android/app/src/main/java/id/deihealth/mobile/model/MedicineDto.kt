package id.deihealth.mobile.model

data class MedicineDto(
    val id: Long,
    val name: String,
    val category: String?,
    val unit: String,
    val defaultDose: String?,
    val minimumStock: Int,
    val currentStock: Int,
    val expiresAt: String?,
)
