package id.deihealth.mobile.api

import id.deihealth.mobile.model.CreateHealthReportRequest
import id.deihealth.mobile.model.HealthReportDto
import id.deihealth.mobile.model.MedicineDto
import id.deihealth.mobile.model.StudentDto
import retrofit2.http.Body
import retrofit2.http.GET
import retrofit2.http.POST
import retrofit2.http.Query

interface DeiHealthApi {
    @GET("api/v1/students")
    suspend fun students(@Query("search") search: String? = null): PaginatedResponse<StudentDto>

    @GET("api/v1/health-reports")
    suspend fun healthReports(@Query("status") status: String? = null): PaginatedResponse<HealthReportDto>

    @POST("api/v1/health-reports")
    suspend fun createHealthReport(@Body request: CreateHealthReportRequest): HealthReportDto

    @GET("api/v1/medicines")
    suspend fun medicines(@Query("low_stock") lowStock: Boolean? = null): PaginatedResponse<MedicineDto>
}

data class PaginatedResponse<T>(
    val data: List<T>,
    val currentPage: Int? = null,
    val total: Int? = null,
)
