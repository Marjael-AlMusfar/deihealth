package id.deihealth.mobile.api

import id.deihealth.mobile.model.CreateHealthReportRequest
import id.deihealth.mobile.model.CreatePrescriptionRequest
import id.deihealth.mobile.model.DailyObservationRequest
import id.deihealth.mobile.model.GenericResponse
import id.deihealth.mobile.model.HealthReportDto
import id.deihealth.mobile.model.LoginRequest
import id.deihealth.mobile.model.RegisterRequest
import id.deihealth.mobile.model.LoginResponse
import id.deihealth.mobile.model.MedicineDto
import id.deihealth.mobile.model.StudentDto
import retrofit2.http.Body
import retrofit2.http.GET
import retrofit2.http.POST
import retrofit2.http.Query
import retrofit2.http.Path

interface DeiHealthApi {
    @POST("api/v1/auth/register")
    suspend fun register(@Body request: RegisterRequest): GenericResponse

    @POST("api/v1/auth/login")
    suspend fun login(@Body request: LoginRequest): LoginResponse

    @POST("api/v1/auth/logout")
    suspend fun logout()

    @GET("api/v1/students")
    suspend fun students(@Query("search") search: String? = null): PaginatedResponse<StudentDto>

    @GET("api/v1/health-reports")
    suspend fun healthReports(@Query("status") status: String? = null): PaginatedResponse<HealthReportDto>

    @POST("api/v1/health-reports")
    suspend fun createHealthReport(@Body request: CreateHealthReportRequest): HealthReportDto

    @POST("api/v1/health-reports/{healthReport}/prescriptions")
    suspend fun createPrescription(@Path("healthReport") healthReportId: Long, @Body request: CreatePrescriptionRequest): GenericResponse

    @POST("api/v1/health-reports/{healthReport}/observations")
    suspend fun createObservation(@Path("healthReport") healthReportId: Long, @Body request: DailyObservationRequest): GenericResponse

    @GET("api/v1/medicines")
    suspend fun medicines(@Query("low_stock") lowStock: Boolean? = null): PaginatedResponse<MedicineDto>
}

data class PaginatedResponse<T>(
    val data: List<T>,
    @com.squareup.moshi.Json(name = "current_page") val currentPage: Int? = null,
    val total: Int? = null,
)
