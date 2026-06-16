package id.deihealth.mobile.model

import com.squareup.moshi.Json

data class MedicineDto(
    val id: Long,
    val name: String,
    val category: String?,
    val unit: String,
    @Json(name = "default_dose") val defaultDose: String?,
    @Json(name = "minimum_stock") val minimumStock: Int,
    @Json(name = "current_stock") val currentStock: Int,
    @Json(name = "expires_at") val expiresAt: String?,
)
